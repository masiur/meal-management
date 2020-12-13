<?php

class BazarController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /bazar
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$bazars = Bazar::with(['member'])->whereMonthId($id)->orderBy('date', 'DESC')->get();

		return View::make('bazar.index')
				->with('title','Bazars')
				->with('bazars',$bazars)
				->with('id',$id);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /bazar/create
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$members = Member::where('user_id', Auth::user()->id)->lists('name', 'id');
		return View::make('bazar.create')
				->with('title','Create Bazars')->with('members',$members)
				->with('id',$id);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /bazar
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'amount' => 'required',
			'month_id' => 'required',
			'member_id' => 'required',
			'date' => 'required'
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$bazar = new Bazar;
		$bazar->month_id = $data['month_id'];
		$bazar->member_id = $data['member_id'];
		$bazar->amount = $data['amount'];
		$bazar->date = $data['date'];
		$bazar->details = $data['details'];

		$data['month'] = $bazar->month;

		$member = Member::find($data['member_id']);
		$flat = Auth::user();
		$data['flat'] = $flat->flat_full_name;
		$data['flat_short_name'] = $flat->flat_short_name;
		$data['flat_email'] = $flat->email;

		$data['member_name'] = $member->name;
		$data['email'] = $member->email;

		if($bazar->save()){

			Mail::send('emails.bazarupdated', $data, function($message) use($data)
			{
			    $message->from('no-reply@general-emailing.masiursiddiki.com', 'No Reply | General Meal System');
			    $message->to($data['email']);
			    $message->subject('Bazar Details | '.$data['flat_short_name'].' | General Meal System');
			    $message->replyTo($data['flat_email']);
			});

			$member->email_count = $member->email_count + 1;
			$member->save();

			return Redirect::route('month.bazar.index',[$data['month_id']])->with('success',"Added Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}


	public function updateEmailCountOfMemberSentTo($value='')
	{
		
	}


	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$members = Member::where('user_id', Auth::user()->id)->lists('name', 'id');
		$bazar = Bazar::find($id);
		return View::make('bazar.edit')
				->with('title','Edit Bazars')->with('members',$members)
				->with('bazar',$bazar);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /bazar/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [
			'amount' => 'required',
			'month_id' => 'required',
//			'member_id' => 'required',
			'date' => 'required'
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$bazar = Bazar::find($id);
		// $bazar->month_id = $data['month_id'];
//		$bazar->member_id = $data['member_id'];
		$bazar->amount = $data['amount'];
		$bazar->date = $data['date'];
        $bazar->details = json_encode($data['details']);

        $data['month'] = $bazar->month;

		$member = Member::find($bazar->member_id);
		$flat = Auth::user();
		$data['flat'] = $flat->flat_full_name;
		$data['flat_short_name'] = $flat->flat_short_name;
		$data['flat_email'] = $flat->email;

		$data['member_name'] = $member->name;
		$data['email'] = $member->email;

		if($bazar->save()){

			Mail::send('emails.bazarupdated', $data, function($message) use($data)
			{
			    $message->from('no-reply@general-emailing.masiursiddiki.com', 'No Reply | General Meal System');
			    $message->to($data['email']);
			    $message->subject('Bazar Details | '.$data['flat_short_name'].' | General Meal System');
			    $message->replyTo($data['flat_email']);
			});

			$member->email_count = $member->email_count + 1;
			$member->save();

			return Redirect::route('month.bazar.index',[$data['month_id']])->with('success',"Updated Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /bazar/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destoryBazar($id)
	{
		try {
			$bazar = Bazar::find($id);
			$bazarId = $bazar->month_id;
			$bazar->delete();
			return Redirect::route('month.bazar.index', $bazarId)->with('success',"Deleted Successfully.");
		} catch (Exception $e) {
			return Redirect::back()->with('error',"Something went wrong.Try again");
		}
	}

}