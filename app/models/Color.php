<?php

class Color extends Eloquent {
	protected $guarded = array();
	protected $hidden = array('id','pivot');

	public static $rules = array();
	public $timestamps = false;

	// can add here morph to many accessors like products, colorizableElements, etc.
}