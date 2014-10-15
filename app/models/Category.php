<?php

class Category extends Eloquent {
	protected $guarded = array();
	protected $hidden = array('created_at','updated_at');

	public static $rules = array(
		'name' => 'required'
	);
}
