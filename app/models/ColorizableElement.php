<?php

class ColorizableElement extends Eloquent {
	protected $guarded = array();
	protected $table = 'colorizableElements';

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
		return $this->morphTo();
	}

	public function colors() {
        return $this->morphToMany('Color', 'colorable','colorable');
    }

}
