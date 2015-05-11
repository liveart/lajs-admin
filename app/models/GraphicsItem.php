<?php

class GraphicsItem extends Eloquent {
	protected $guarded = array();
	protected $table = 'graphicsItems';
    protected $hidden = array('category_id','colorizables');

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required',
        'category_id' => 'required|exists:graphicsCategories,id',
		'description' => 'required',
		'colors' => 'required',
		'thumb' => 'required',
		'image' => 'required'
	);

	public function category() {
		return $this->belongsTo('GraphicsCategory','category_id');
	}

	public function colorizables() {
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
                unset($g['category_id']);
                $g['colorize'] = ($g['colorize'] == 'on') ? true : false;
				$g['multicolor'] = count($g->colorizables) > 0;
                $g['colorizableElements'] = $g->colorizables;
                foreach ($g['colorizableElements'] as $ce) {
                    $ce->colors; // lazy fetch colors if present
                    $ce['id'] = $ce['css_id'];
                }
                // TODO add colors list if present, from rel-096
			}
		}
		$json['graphicsCategoriesList'] = $cats;
		return $json;
	}

}
