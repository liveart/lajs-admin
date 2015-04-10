<?php

class ColorizableElement extends Eloquent {
	protected $guarded = array();
	protected $table = 'colorizableElements';
	protected $hidden = array('css_id','of_id','of_type');

	public static $rules = array(
		'css_id' => 'required',
		'name' => 'required'
	);

	public $timestamps = false;

	/** 
	 * This will get either product or the gallery item
	 *
	 */
	public function colorizable() {
		return $this->morphTo('of');
	}

	public function colors() {
        return $this->morphToMany('Color', 'colorable','colorable');
    }

}
