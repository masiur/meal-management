<?php

class Month extends \Eloquent {
	protected $fillable = [];

	public function posts()
    {
        return $this->hasMany('Post');
    }

}