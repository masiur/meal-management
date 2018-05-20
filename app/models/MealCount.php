<?php

class MealCount extends \Eloquent {
	protected $fillable = [];
	public function member(){
		return $this->belongsTo('Member');
	}
}