<?php

class Location extends Eloquent {
	protected $guarded = array();
	protected $hidden = array('id', 'product_id');
	public $timestamps = false;

	public static $rules = array(
		'name' => 'required'
	);

	public function product() {
		return $this->belongsTo('Product');
	}

	// general accessor to all coord types for location
	public function getCoords($type) {
		$att = $this->getAttribute($type);
		$vals = array_map(function($v) {return intval($v);},explode('/',$att));
		return $vals;
	}

	public function setCoords($vals, $type) {
		$this->setAttribute($type, implode('/', $vals));
	}
}
