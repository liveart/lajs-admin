<?php

class GraphicsCategory extends Eloquent {
	protected $guarded = array();
	protected $table = 'graphicsCategories';

	public $timestamps = false;

	public static $rules = array(
		'name' => 'required'
	);
}