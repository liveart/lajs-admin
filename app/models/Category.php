<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Category extends Eloquent implements StaplerableInterface {
    use EloquentTrait;

	protected $guarded = array();
	protected $hidden = array('created_at','updated_at','thumb_file_name', 'thumb_file_size', 'thumb_content_type', 'thumb_content_type', 'thumb_updated_at');
    protected $fillable = ['name', 'thumbUrl', 'thumb'];

	public static $rules = array(
		'name' => 'required'
	);

    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('thumb', [
            'styles' => [
                'thumb' => '110x110'
            ],
            'default_url' => 'assets/images/noimage.png'
        ]);
        parent::__construct($attributes);
    }

}
