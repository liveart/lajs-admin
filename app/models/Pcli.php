<?php

class Pcli extends Eloquent {
	protected $guarded = array();
	protected $hidden = array('id','product_id','location_id','color_id','location','color');
	public $timestamps = false;

	public static $rules = array();

	public function product() {
		return $this->belongsTo('Product');
	}

	public function location() {
		return $this->belongsTo('Location');
	}

	public function color() {
		return $this->belongsTo('Color');
	}

}