<?php

class Post extends \Eloquent {
	protected $fillable = [];

    public function month()
    {
        return $this->belongsTo('Month');
    }
}