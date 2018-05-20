<?php

class Member extends \Eloquent {
    protected $fillable = [];

    public function mealCount(){
        return $this->hasOne('MealCount');
    }

    // public function bazars(){
    // 	return $this->hasMany('MealCount');
    // }
}