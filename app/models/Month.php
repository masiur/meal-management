<?php

class Month extends \Eloquent {
	protected $fillable = [];

	public function posts()
    {
        return $this->hasMany('Post');
    }

    public function mealCounts()
    {
        return $this->hasMany('MealCount');
    }

    public function mealCounts2()
    {
        return $this->hasMany('MealCount')->with('member');
    }

}