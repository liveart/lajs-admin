<?php

class Product extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'categoryId' => 'required|exists:categories,id',
		'description' => 'required',
		'price' => 'required'
	);

	public function category() {
		return $this->belongsTo('Category','categoryId');
	}
}