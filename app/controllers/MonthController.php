<?php

class MonthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /month
	 *
	 * @return Response
	 */
	public function index()
	{
		$months = Month::where('user_id', Auth::user()->id)->orderBy('start_time','DESC')->get();
		return View::make('month.index')
				->with('title','Months/Sessions')
				->with('months',$months);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /month/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('month.create')
					->with('title','Create Month');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /month
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'name' => 'required',
			'cost' => 'required',
			'notes' => ''
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$month = new Month;
		$month->name = $data['name'];
		$month->cost = $data['cost'];
		$month->notes = $data['notes'];
		$month->start_time = $data['start_time'];
		$month->user_id = Auth::user()-id;
		if($month->save()){
			return Redirect::route('month.index')->with('success',"Added Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Display the specified resource.
	 * GET /month/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /month/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$month = Month::find($id);
		return View::make('month.edit')
					->with('title','Edit Month')
					->with('month',$month);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /month/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [
			'name' => 'required',
			'cost' => 'required',
			];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$month = Month::find($id);
		$month->name = $data['name'];
		$month->cost = $data['cost'];
		$month->notes = $data['notes'];
		$month->start_time = $data['start_time'];
		$month->closing_time = $data['closing_time'];
		if($month->save()){
			return Redirect::route('month.index')->with('success',"Updated Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /month/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}

}