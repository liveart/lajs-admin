<?php

class GraphicsItem extends Eloquent {
	protected $guarded = array();
	protected $table = 'graphicsItems';

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required',
		'description' => 'required',
		'colors' => 'required',
		'thumb' => 'required',
		'image' => 'required'
	);

	public function colorizableElements() {
    	return $this->morphMany('ColorizableElement', 'of');
    }

	public function getJSON() {
		$json = array();
		$cats = GraphicsCategory::orderBy('name','asc')->get();
		foreach ($cats as $cat) {
			$cat['graphicsList'] = GraphicsItem::where('category_id','=',$cat->id)->get();
			foreach ($cat['graphicsList'] as $g) {
				$g['colors'] = strval($g['colors']);
				$g['categoryId'] = $g['category_id'];
				// TODO "multicolor": true, if colorizable elements present
				// TODO fetch and render colorizable elements 
			}
		}
		$json['graphicsCategoriesList'] = $cats;
		return $json;
	}

}
