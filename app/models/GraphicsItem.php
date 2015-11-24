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
		$cats = GraphicsCategory::whereNull('parent')->orWhere('parent', '=', '0')->orderBy('name','asc')->get();
		foreach ($cats as $cat) {
            $this->buildCategory($cat);
		}
        $arr = $cats->toArray();
        // now real cleaning out
        foreach ($arr as &$el) {
            // map to properly named attributes and remove junk
            $this->cleanCategory($el);
        }
        $json['graphicsCategoriesList'] = $arr;
        return $json;
	}

    private function cleanCategory(&$cat) {
        $cat['thumb'] = $cat['thumbURL'];
        $cat = array_only($cat, array('id', 'categories', 'name', 'thumb', 'graphicsList'));
        foreach ($cat['categories'] as &$c) {
            $this->cleanCategory($c);
        }
    }

    /**
     * @param $cat
     */
    private function buildCategory($cat)
    {
        $temp = array();
        // checking for children
        foreach ($cat->categories as $child) {
            $this->buildCategory($child);
            array_push($temp, $child->toArray());
        }
        if (count($temp) > 0) {
            $cat['categories'] = $temp;
        }
        $cat['thumbURL'] = URL::to($cat->thumb->url());
        $cat['graphicsList'] = GraphicsItem::where('category_id', '=', $cat->id)->get();
        foreach ($cat['graphicsList'] as $g) {
            $g['colors'] = strval($g['colors']);
            $g['categoryId'] = $g['category_id'];
            unset($g['category_id']);
            $g['thumb'] = URL::to($g->thumbFile->url());
            $g['image'] = URL::to($g->imageFile->url());
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

}
