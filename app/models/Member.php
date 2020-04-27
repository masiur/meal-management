<?php

class Member extends \Eloquent {
    protected $fillable = [];

    public function mealCount(){
        return $this->hasMany('MealCount');
    }

    // public function bazars(){
    // 	return $this->hasMany('MealCount');
    // }
}