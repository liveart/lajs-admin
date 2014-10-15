<?php

class Product extends Eloquent {
	protected $guarded = array();
	public $timestamps = false;

	public static $rules = array(
		'name' => 'required',
		'categoryId' => 'required|exists:categories,id',
		'description' => 'required',
		'price' => 'required'
	);

	public function category() {
		return $this->belongsTo('Category','categoryId');
	}

	public function locations() {
        return $this->hasMany('Location');
    }

    public function colors() {
        return $this->morphMany('Color', 'of');
    }

    public function colorizableElements() {
    	return $this->hasMany('ColorizableElement');
    }

}