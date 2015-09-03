<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class GraphicsCategory extends Eloquent implements StaplerableInterface {
    use EloquentTrait;

	protected $guarded = array();
	protected $fillable = array('name', 'thumb', 'parent');
    protected $table = 'graphicsCategories';

	public $timestamps = false;

	public static $rules = array(
		'name' => 'required'
	);

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('thumb', [
            'styles' => [
                'thumb' => '110x110'
            ],
            'default_url' => 'assets/images/noimage.png'
        ]);
        parent::__construct($attributes);
    }

    public function parentCategory() {
        return $this->belongsTo('GraphicsCategory','parent');
    }

    public function categories() {
        return $this->hasMany('GraphicsCategory', 'parent');
    }

}