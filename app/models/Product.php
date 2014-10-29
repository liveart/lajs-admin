<?php

class Product extends Eloquent {
	protected $guarded = array();
	public $timestamps = false;
	protected $hidden = array('colorizables');

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

    public function colorizables() {
    	return $this->morphMany('ColorizableElement', 'of');
    }

    public function getJSON() {
		$json = array();
		$cats = Category::all();
		$json['productCategoriesList'] = $cats;
		foreach ($cats as $cat) {
			$cat['products'] = Product::where('categoryId','=',$cat->id)->get();
			// adjust attributes for proper schema
			$atts = array('multicolor','resizable','showRuler','namesNumbersEnabled');
			foreach ($cat['products'] as $prod) {
				foreach ($atts as $att) {
					$prod->setAttribute($att, ($prod->getAttribute($att)=="on"));
				}
				$prod['locations'] = Location::where('product_id','=',$prod->id)->get();
				foreach ($prod['locations'] as $loc) {
					$loc->editableArea = $loc->getCoords('editableArea');
					$loc->editableAreaUnits = $loc->getCoords('editableAreaUnits');
					$loc->clipRect = $loc->getCoords('clipRect');
				}
				foreach ($prod->colorizables as $el) {
					$el->id = $el->css_id;
				}
				$prod['colorizableElements'] = $prod['colorizables'];

				// TODO product color location images
				$prod['sizes'] = explode(',', $prod['sizes']);
			}
		}
		return $json;
	}

}