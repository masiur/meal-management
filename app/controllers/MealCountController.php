<?php

class MealCountController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /mealcount
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$mealcounts = MealCount::with(['member'])->whereMonthId($id)->get();

		return View::make('meal.index')
				->with('title','Meal Counts')
				->with('mealcounts',$mealcounts)
				->with('id',$id);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /mealcount/create
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$members = Member::where('user_id', Auth::user()->id)->lists('name', 'id');
		return View::make('meal.create')
				->with('title','Create Cumulative Meal')->with('members',$members)
				->with('id',$id);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /mealcount
	 *
	 * @return Response
	 */
	public function store($id)
	{
		$rules = [
			'month_id' => 'required',
			'member_id' => 'required',
			'count' => 'required',
			'balance' => 'required'
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$mealcount = new MealCount;
		$mealcount->month_id = $data['month_id'];
		$mealcount->member_id = $data['member_id'];
		$mealcount->count = $data['count'];
		$mealcount->balance = $data['balance'];

		$mealcount->notes = $data['notes'];

		if($mealcount->save()){
			return Redirect::route('month.meal.index',[$data['month_id']])->with('success',"Added Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Display the specified resource.
	 * GET /mealcount/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	public function sendEmailOfMealDetails($id)
	{
		try {
			$mealcount = MealCount::with('member')->with('month')->find($id);

			$data['month'] = $mealcount->month;

			$data['meal_count'] = $mealcount->count;
			$data['balance'] = $mealcount->balance;

			$member = $mealcount->member;

			$bazarOfThisMemberOfThisMonth = Bazar::where('month_id', $data['month']->id)->where('member_id', $member->id)->get();
			$data['bazars'] = $bazarOfThisMemberOfThisMonth;

	
			$data['bazar_count'] = count($bazarOfThisMemberOfThisMonth);
			$flat = Auth::user();
			$data['flat'] = $flat->flat_full_name;
			$data['flat_short_name'] = $flat->flat_short_name;
			$data['flat_email'] = $flat->email;

			$data['member_name'] = $member->name;
			$data['email'] = $member->email;

			Mail::send('emails.mealdetails', $data, function($message) use($data)
			{
			    $message->from('no-reply@general-emailing.masiursiddiki.com', 'No Reply | General Meal System');
			    $message->to($data['email']);
			    $message->subject('Meal Details | '.$data['flat_short_name'].' | General Meal System');
			    $message->replyTo($data['flat_email']);
			});

			$member->email_count = $member->email_count + 1;
			$member->save();
			
			return Redirect::route('month.meal.index', [$data['month']->id])->with('success', 'Email Sent to the Member Successfully');
		} catch (Exception $e) {
			return Redirect::route('month.meal.index')->with('error', 'Something wen wrong');
		}
		

		
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /mealcount/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$members = Member::where('user_id', Auth::user()->id)->lists('name', 'id');
		$mealcount = MealCount::find($id);
		return View::make('meal.edit')
				->with('title','Edit Cumulative Meal Info')->with('members',$members)
				->with('mealcount',$mealcount);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /mealcount/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [
			'month_id' => 'required',
//			'member_id' => '',
			'count' => 'required',
			'balance' => 'required'
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$mealcount =  MealCount::find($id);
		$mealcount->month_id = $data['month_id'];
//		$mealcount->member_id = $data['member_id'];
		$mealcount->count = $data['count'];
		$mealcount->balance = $data['balance'];
		$mealcount->notes = $data['notes'];
		$mealcount->status = $data['status'];

		if($mealcount->save()){
			return Redirect::route('month.meal.index',[$data['month_id']])->with('success',"Updated Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /mealcount/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}