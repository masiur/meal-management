<?php

class MealCount extends \Eloquent {
	protected $fillable = [];


	public function member(){
		return $this->belongsTo('Member');
	}
	public function month(){
		return $this->belongsTo('Month');
	}
}