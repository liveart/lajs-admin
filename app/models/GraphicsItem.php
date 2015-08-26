<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class GraphicsItem extends Eloquent implements StaplerableInterface {
    use EloquentTrait;

	protected $guarded = array();
	protected $table = 'graphicsItems';
    protected $hidden = array('category_id','colorizables');
    protected $fillable = ['category_id', 'name', 'description', 'colors', 'thumb', 'image', 'thumbFile', 'imageFile'];

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required',
        'category_id' => 'required|exists:graphicsCategories,id',
		'description' => 'required',
		'colors' => 'required');

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('thumbFile', [
            'styles' => [
                'thumb' => '110x110'
            ],
            'default_url' => 'assets/images/noimage.png'
        ]);
        $this->hasAttachedFile('imageFile');
        parent::__construct($attributes);
    }

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
            $cat['thumbURL'] = $cat->thumb->url();
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
        $arr = $cats->toArray();
        // now real cleaning out
        foreach ($arr as &$el) {
            // map to properly named attributes and remove junk
            $el['thumb'] = $el['thumbURL'];
            $el = array_only($el, array('id', 'name', 'thumb', 'graphicsList'));
        }

        $json['graphicsCategoriesList'] = $arr;

        return $json;
	}

}
