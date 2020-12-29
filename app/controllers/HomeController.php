<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		return View::make('welcome')
				->with('title', "Home");
	}

	public function showWelcome()
	{
		$monthName = Input::get('month');
	    $month = $monthName ? Month::where('name', strtolower($monthName))->first() : Month::orderBy('id', 'desc')->first();

	    if(!$month) {
            return "<h1>Oops! Bad Request</h1>";
        }

		$total_meal_count = 0.00;

		$total_bazar = $month->cost;
		$monthCost = $total_bazar;

        $monthId = $month->id;
		
         $bazars = Bazar::with('member')->whereMonthId($monthId)->get();
		
        $meal_counts = MealCount::whereMonthId($monthId)->with('Member')->get();

		foreach ($bazars as $bazar) {
			$total_bazar +=  $bazar->amount;
		}

		foreach ($meal_counts as $meal) {
			$total_meal_count +=  $meal->count;
		}
		
		$meal_rate = $total_meal_count != 0 ? number_format($total_bazar/$total_meal_count, 2) : 0;

//		$GLOBALS['month_id'] = $month->id;

//        $memberForSelectedMonth = $meal_counts->lists('member_id');
////		  $members = Member::whereIn('id', $memberForSelectedMonth)->with('mealCount')->get();
//        $members = Member::whereIn('id', $memberForSelectedMonth)
//             ->with(['mealCount' => function($query) use($monthId){
//				    $query->where('month_id', $monthId)->first();
//				}])
//             ->get();
//
//		foreach ($members as $member) {
////            return $memberMealDetails = $member->meal_count->('month_id', $monthId)->first();
////		    $member->member_meal_details = $memberMealDetails;
//			$member->has = $memberMealDetails->balance - ($memberMealDetails->count * $meal_rate);
//		}
//		$members;

        $mealDetailsAllMembers = $meal_counts;
        foreach ($meal_counts as $mealCountPerMember) {
            $mealCountPerMember->total_bazar_per_head = Bazar::where('month_id', $monthId)->where('member_id', $mealCountPerMember->member_id)->sum('amount');
            $mealCountPerMember->balancePlusOrMinusToBeGiven =  ($mealCountPerMember->total_bazar_per_head + $mealCountPerMember->balance) - ($mealCountPerMember->count * $meal_rate)  ;
//            $mealCountPerMember->total_bazar_per_head = 20;
        }
        $mealDetailsAllMembers;

		return View::make('home')->with('title', 'Home')
//							->with('members', $members)
							->with('mealDetailsAllMembers', $mealDetailsAllMembers)
							->with('bazars', $bazars)
							->with('total_bazar_this_month', $total_bazar)
							->with('total_meal_this_month', $total_meal_count)
							->with('monthCost', $monthCost)
							->with('month', $month)
							->with('meal_rate', $meal_rate);
	}

	
	public function showMonthByUser($user)
	{
		$monthName = Input::get('month');
		$user = User::where('flat_short_name', $user)->first();
		$month = $monthName ? Month::where('name', strtolower($monthName))->where('user_id', $user->id)->first() : Month::where('user_id', $user->id)->orderBy('start_time','DESC')->first();

	    if(!$month) {
            return "<h1>Oops! Bad Request</h1>";
        }
        return $this->calculateMealbyMonthByUser($month, $user->flat_short_name);

	}

	public function calculateMealbyMonthByUser($month, $user)
	{

		$total_meal_count = 0.00;

		$total_bazar = $month->cost;
		$monthCost = $total_bazar;

        $monthId = $month->id;
		
        $bazars = Bazar::with('member')->whereMonthId($monthId)->orderBy('date', 'DESC')->get();
		
        $meal_counts = MealCount::whereMonthId($monthId)->with('Member')->get();

		foreach ($bazars as $bazar) {
			$total_bazar +=  $bazar->amount;
		}

		foreach ($meal_counts as $meal) {
			$total_meal_count +=  $meal->count;
		}
		
		$meal_rate = $total_meal_count != 0 ? number_format($total_bazar/$total_meal_count, 2) : 0;


        $mealDetailsAllMembers = $meal_counts;
        foreach ($meal_counts as $mealCountPerMember) {
            $mealCountPerMember->total_bazar_per_head = Bazar::where('month_id', $monthId)->where('member_id', $mealCountPerMember->member_id)->sum('amount');
            $mealCountPerMember->balancePlusOrMinusToBeGiven =  ($mealCountPerMember->total_bazar_per_head + $mealCountPerMember->balance) - ($mealCountPerMember->count * $meal_rate)  ;
//            $mealCountPerMember->total_bazar_per_head = 20;
        }
        $mealDetailsAllMembers;

		return View::make('home')->with('title', $user. ' | Calculation')
							->with('flat', $user)
							->with('mealDetailsAllMembers', $mealDetailsAllMembers)
							->with('bazars', $bazars)
							->with('total_bazar_this_month', $total_bazar)
							->with('total_meal_this_month', $total_meal_count)
							->with('monthCost', $monthCost)
							->with('month', $month)
							->with('meal_rate', $meal_rate);
	
	}

    public function mealRateCalculate($id)
    {
        $monthId = $id;

        $total_meal_count = 0.00;

        $bazars = Bazar::with('member')->whereMonthId($monthId)->orderBy('date', 'DESC')->get();

        $meal_counts = MealCount::whereMonthId($monthId)->with('Member')->get();

        $month = Month::findOrFail($id);

        $total_bazar = 0.00; // init variable

        foreach ($bazars as $bazar) {
            $total_bazar +=  $bazar->amount;
        }

        $total_spent_this_month = $total_bazar + $month->cost; // month cost means mess bazar

        foreach ($meal_counts as $meal) {
            $total_meal_count +=  $meal->count;
        }

        $meal_rate = $total_meal_count != 0 ? number_format($total_spent_this_month/$total_meal_count, 2) : 0;

        $month->meal_rate = $meal_rate;
        $month->save();

        return Redirect::back()->with('success',"Meal Calculated/Recalculated Successfully.");


	}

    public function generateBill()
    {
        $monthId = Input::get('month');
        $memberId = Input::get('member');


         $bazarsByMemberByMonth = Bazar::where('member_id', $memberId)->whereMonthId($monthId)->orderBy('date', 'DESC')->get();

         $meal_counts = MealCount::whereMonthId($monthId)->where('member_id', $memberId)->first();

         $meal_rate = $meal_counts->month->meal_rate;

        $total_bazar = $bazarsByMemberByMonth->sum('amount');

        $flat = $meal_counts->member->user;

        return View::make('meal_details')->with('bazars', $bazarsByMemberByMonth)
                                ->with('meal_rate', $meal_rate)
                                ->with('meals', $meal_counts)
                                ->with('flat', $flat)
                                ->with('total_bazar', $total_bazar);
	}

}
