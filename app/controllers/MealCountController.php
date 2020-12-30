<?php

class MealCountController extends \BaseController
{

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
            ->with('title', 'Meal Counts')
            ->with('mealcounts', $mealcounts)
            ->with('id', $id);
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
            ->with('title', 'Create Cumulative Meal')->with('members', $members)
            ->with('id', $id);
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

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $mealcount = new MealCount;
        $mealcount->month_id = $data['month_id'];
        $mealcount->member_id = $data['member_id'];
        $mealcount->count = $data['count'];
        $mealcount->balance = $data['balance'];

        $mealcount->notes = $data['notes'];

        if ($mealcount->save()) {
            return Redirect::route('month.meal.index', [$data['month_id']])->with('success', "Added Successfully.");
        }
        return Redirect::back()->with('error', "Something went wrong.Try again");
    }

    /**
     * Display the specified resource.
     * GET /mealcount/{id}
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function emailInvoiceOfMealDetails($id)
    {

        try {
            $mealcount = MealCount::with('member')->with('month')->find($id);

            $data['month'] = $mealcount->month;

            if($data['month']->status != 'COMPLETED') {
                return Redirect::route('month.meal.index', [$data['month']->id])->with('warning', 'Session is not COMPLETED yet.');
            }

            $data['meal_count'] = $mealcount->count;
            $data['balance'] = $mealcount->balance;

            $member = $mealcount->member;


             $flat = $mealcount->member->user;

            $data['flat'] = $flat->flat_full_name;
            $data['flat_short_name'] = $flat->flat_short_name;
            $data['flat_email'] = $flat->email;

            $data['member_name'] = $member->name;
            $data['email'] = $member->email;

            $filename = public_path().'/invoices/Invoice_'.$data['member_name'].date('_Y_m_d_h_m_s').".pdf";

            $data['filename'] = $filename;

            // generating pdf
            $printHtmlUrl = URL::route('bill.index', array('member' => $mealcount->member_id, 'month' => $mealcount->month_id));

            $url = "https://api.sejda.com/v2/html-pdf";

            $content = json_encode(array
                ('url' => $printHtmlUrl,
                    'pageSize' => 'a4'
                )
            );
            $apiKey = "api_F2EE618D80564415AFC0C84CE1F28B03";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-type: application/json",
                "Authorization: Token: " . $apiKey));

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($status == 200) {
                $fp = fopen($filename, "w");
                fwrite($fp, $response);
                fclose($fp);
                print("PDF saved to disk");

                Mail::send('emails.mealinvoice', $data, function ($message) use ($data) {
                    $message->from('no-reply@general-emailing.masiursiddiki.com', 'No Reply | General Meal System');
                    $message->to($data['email']);
                    $message->subject('Invoice of '.$data['month']->name. ' Session | ' . $data['flat_short_name'] . ' | General Meal System');
                    $message->attach($data['filename']);
                    $message->replyTo($data['flat_email']);
                });

                $member->email_count = $member->email_count + 1;
                $member->save();


            } else {
                print("Error: failed with status $status, response $response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
            }


            return Redirect::route('month.meal.index', [$data['month']->id])->with('success', 'Email Sent to the Member Successfully');
        } catch (Exception $e) {
            return $e;
            return Redirect::route('month.meal.index', [$data['month']->id])->with('error', 'Something went wrong');
        }


    }

    public function sendInvoiceOfMealDetails($id)
    {
        try {
            $mealcount = MealCount::with('member')->with('month')->find($id);

            $data['month'] = $mealcount->month;


            $member = $mealcount->member;


            Mail::send('emails.mealdetails', $data, function ($message) use ($data) {
                $message->from('no-reply@general-emailing.masiursiddiki.com', 'No Reply | General Meal System');
                $message->to($data['email']);
                $message->subject('Meal Details | ' . $data['flat_short_name'] . ' | General Meal System');
                $message->replyTo($data['flat_email']);
            });

            $member->email_count = $member->email_count + 1;
            $member->save();

            return Redirect::route('month.meal.index', [$data['month']->id])->with('success', 'Email Sent to the Member Successfully');
        } catch (Exception $e) {
            return Redirect::route('month.meal.index')->with('error', 'Something wen wrong');
        }
    }




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