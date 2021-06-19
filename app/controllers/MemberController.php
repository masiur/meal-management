<?php

class MemberController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /member
	 *
	 * @return Response
	 */
	public function index()
	{
		$members = Member::where('user_id', Auth::user()->id)->get();
		return View::make('member.index')
				->with('title','Members')
				->with('members',$members);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /member/create
	 *
	 * @return Response
	 */
	public function create()
	{
		

		return View::make('member.create')
					->with('title','Add New Member');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /member
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'name' => 'required',
			'email' => 'required|email|unique:members',
			'mobile' => 'required|unique:members',
			'address' => 'required',
		];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$member = new Member;
		$member->name = $data['name'];
		$member->mobile = $data['mobile'];
		$member->email = $data['email'];
		$member->address = $data['address'];
		$member->user_id = Auth::user()->id;

		if($member->save()){
			return Redirect::route('member.index')->with('success',"Added Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Display the specified resource.
	 * GET /member/{id}
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
	 * GET /member/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$member = Member::find($id);
		return View::make('member.edit')
					->with('title','Edit Member')
					->with('member',$member);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /member/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [
			'name' => 'required',
			'email' => 'required|email',
			'mobile' => 'required',
			'address' => 'required',
			];

		$data = Input::all();
		$validator = Validator::make($data, $rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$member = Member::find($id);
		$member->name = $data['name'];
		$member->mobile = $data['mobile'];
		$member->email = $data['email'];
		$member->address = $data['address'];

		if($member->save()){
			return Redirect::route('member.index')->with('success',"Updated Successfully.");
		}
		return Redirect::back()->with('error',"Something went wrong.Try again");
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /member/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function sendSMS()
	{
	    $input =  \Illuminate\Support\Facades\Input::all();
         $recipientIds = unserialize(base64_decode($input['recipients']));
          $members = Member::whereIn('id', $recipientIds)->get();
//
        $smsText = $input['sms_text'];
        $counter = 1;
        foreach ($members as $recipient) {
            if($counter > 1) {
                break;
            }
            if(strlen($recipient->mobile) >= 11) {
                $text = "Dear ".$recipient->name.", ".$smsText." - C1 Meal System.";
                $this->sendMessageByNumberAndText($recipient->mobile, $text);
            }
            $counter++;

        }
        return Redirect::route('month.meal.index',[$input['month_id']])->with('success', "SMS sent to Members of this month successfully.");

    }

    public function sendMessageByNumberAndText($number, $text)
    {
        try{
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'userName' => "01711107915",
                'userPassword' => "17111",
                'mobileNumber' => $number,
                'smsText' => $text,
                'smsType' => "TEXT",
                'maskName' => '',
                'campaignName' => '',
            );
            $value = $soapClient->__call('OneToOne', [$paramArray]);
//            echo $value->OneToOneResult;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}