<?php

class Bazar extends \Eloquent {
	protected $fillable = [];
	public function member(){
		return $this->belongsTo('Member');
	}
}