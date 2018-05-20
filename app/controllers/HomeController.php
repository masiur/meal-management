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

	public function showWelcome()
	{
		$month = Month::orderBy('id', 'desc')->first();

		$total_meal_count = 0.00;

		$total_bazar = $month->cost;
		$monthCost = $total_bazar;
		
		$bazars = Bazar::with('member')->whereMonthId($month->id)->get();
		
		$meal_counts = MealCount::whereMonthId($month->id)->get();

		foreach ($bazars as $bazar) {
			$total_bazar +=  $bazar->amount;
		}

		foreach ($meal_counts as $meal) {
			$total_meal_count +=  $meal->count;
		}
		
		$meal_rate = $total_bazar/$total_meal_count;
		$GLOBALS['month_id'] = $month->id;
		$members = Member::with(['mealCount' => function($query){
				    $query->where('month_id', $GLOBALS['month_id']);

				}])->get();

		foreach ($members as $member) {

			$member->has = $member->meal_count->balance - ($member->meal_count->count * $meal_rate);
		}
		$members;


		return View::make('home')->with('title', 'Home')
							->with('members', $members)
							->with('bazars', $bazars)
							->with('monthCost', $monthCost)
							->with('month', $month)
							->with('meal_rate', $meal_rate);
	}

}
