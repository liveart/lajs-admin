<?php

class Font extends Eloquent {
	protected $guarded = array();
	protected $hidden = array('id');
	public $timestamps = false;

	public static $rules = array(
		'name' => 'required',
		'fontFamily' => 'required',
		'ascent' => 'required'
	);
}
