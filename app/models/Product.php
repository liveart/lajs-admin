<?php

class Product extends Eloquent {
	protected $guarded = array();
	public $timestamps = false;
	protected $hidden = array('colorizables','pclis');

	public static $rules = array(
		'name' => 'required',
		'categoryId' => 'required|exists:categories,id',
		'description' => 'required'
	);

	public function category() {
		return $this->belongsTo('Category','categoryId');
	}

	public function locations() {
        return $this->hasMany('Location');
    }

    public function colors() {
        return $this->morphToMany('Color', 'colorable','colorable');
    }

    public function colorizables() {
    	return $this->morphMany('ColorizableElement', 'of');
    }

	public function pclis() {
		return $this->hasMany('Pcli');
	}

    /**
     * Generate API json for LiveArt component
     * @return array
     */
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
				// Colors and Location Images
				$prod['colors'] = $prod->colors;
				foreach ($prod['colors'] as $col) {
					// filter out the correct location images
					$pclis = array_where($prod->pclis, function ($k, $v) use ($col) {
						return $v->color->name == $col->name;
					});
					if (count($pclis)) {
						$col['location'] = $pclis;
						// update with custom name field
						$col['location'] = array_map(function ($v) {
							$v['name'] = $v->location->name;
							return $v;
						}, $col['location']);
						$col['location'] = array_values($col['location']);
					}
				}
                if (count($prod->colorizables) > 0) {
                    foreach ($prod->colorizables as $el) {
                        $el->id = $el->css_id;
                    }
                    $prod['colorizableElements'] = $prod['colorizables'];
                }
				$prod['data'] = json_decode($prod['data']);
				$prod['sizes'] = explode(',', $prod['sizes']);
			}
		}
		return $json;
	}

}