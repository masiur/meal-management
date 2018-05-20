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
		$bazars = Bazar::with(['member'])->whereMonthId($id)->get();

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
		$members = Member::lists('name', 'id');
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

		if($bazar->save()){
			return Redirect::route('month.bazar.index',[$data['month_id']])->with('success',"Added Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Display the specified resource.
	 * GET /bazar/{id}
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
	 * GET /bazar/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$members = Member::lists('name', 'id');
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
			'member_id' => 'required',
			'date' => 'required'
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$bazar = Bazar::find($id);
		$bazar->month_id = $data['month_id'];
		$bazar->member_id = $data['member_id'];
		$bazar->amount = $data['amount'];
		$bazar->date = $data['date'];

		if($bazar->save()){
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
	public function destroy($id)
	{
		//
	}

}