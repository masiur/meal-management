<?php

class FlatController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /flat
	 *
	 * @return Response
	 */
	public function index()
	{
		$flats = User::all();
		return View::make('flats.index')
				->with('title','Flats/Users')
				->with('flats',$flats);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /flat/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('flats.create')
					->with('title','Add New User/Flat');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /flat
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'flat_short_name' => 'required|unique:users',
			'email' => 'required|email|unique:users',
			'flat_mobile_number' => 'required|unique:users',
			'flat_address' => 'required',
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		// if($validator->fails()){
		// 	return Redirect::back()->withInput()->withErrors($validator);
		// }
		$user = new User;
		$user->flat_short_name = $data['flat_short_name'];
		$user->flat_mobile_number = $data['flat_mobile_number'];
		$user->email = $data['email'];
		$user->flat_address = $data['flat_address'];

		$data['password'] = str_random(6);
		$user->password = Hash::make($data['password']);


		if($user->save()){

			Mail::send('emails.flatcreated', $data, function($message) use($data)
			{
			    $message->from('no-reply@general-emailing.masiursiddiki.com', 'General Meal System');
			    $message->to($data['email'], $data['flat_short_name'])->subject('User Creation | General Meal System');
			});
			return Redirect::route('user.index')->with('success',"Added Successfully\n Username: ".$data['flat_short_name']. "\n
				Password: ".$data['password']. " \n Password Has been emailed to you."]);
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Display the specified resource.
	 * GET /flat/{id}
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
	 * GET /flat/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /flat/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /flat/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}