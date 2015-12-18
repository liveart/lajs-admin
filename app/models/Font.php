<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Font extends Eloquent implements StaplerableInterface {
    use EloquentTrait;

	protected $guarded = array();
	protected $hidden = array('id');
    protected $fillable = array('name', 'fontFamily', 'vector', 'ascent', 'regular', 'bold', 'italic', 'bold_italic', 'vector_font');

	public $timestamps = false;

	public static $rules = array(
		'name' => 'required',
		'fontFamily' => 'required'
	);

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('regular');
        $this->hasAttachedFile('bold');
        $this->hasAttachedFile('italic');
        $this->hasAttachedFile('bold_italic');
        $this->hasAttachedFile('vector_font');
        parent::__construct($attributes);
    }

    public function setVector($value) {
        if (is_null($value)) {
            $this->setAttribute('vector', 'default');
        }
    }

	public function getJSON() {
		$json = array();
		$json['fonts'] = $this->orderBy('name','asc')->get();
		foreach ($json['fonts'] as $fn) {
			// get the right data format
			$fn->boldAllowed = ($fn->boldAllowed == "1");
			$fn->italicAllowed = ($fn->italicAllowed == "1");
			$fn->ascent = intval($fn->ascent);
            $fn->vector = URL::to($fn->vector_font->url());
        }
        $json['fonts'] = array_map(function($v) {
            return array_only($v, array('name', 'fontFamily', 'ascent', 'vector', 'boldAllowed', 'italicAllowed'));
        }, $json['fonts']->toArray());
		return $json;
	}

    public function getCSS() {
        $out = '';

        $fonts = $this->orderBy('name','asc')->get();
        foreach ($fonts as $fn) {
            $temp = '';
            // regular
            if ($fn->regular->originalFilename()) {
                $temp = $this->buildFaceCSS($fn->fontFamily, URL::to($fn->regular->url()), 'normal', 'normal');
            }
            // bold - we assume the file is uploaded if checkbox is checked
            if ($fn->boldAllowed) {
                $temp .= $this->buildFaceCSS($fn->fontFamily, URL::to($fn->bold->url()), 'bold', 'normal');
            }
            // italic - same as bold
            if ($fn->italicAllowed) {
                $temp .= $this->buildFaceCSS($fn->fontFamily, URL::to($fn->italic->url()), 'normal', 'italic');
            }
            // bold italic - to check of both are checked
            if (($fn->boldAllowed) && ($fn->italicAllowed)) {
                $temp .= $this->buildFaceCSS($fn->fontFamily, URL::to($fn->bold_italic->url()), 'bold', 'italic');
            }
            $out .= $temp;
        }
        return $out;
    }

    private function buildFaceCSS($family, $url, $weight, $style) {

        // return css record
        return <<<EOT
@font-face {
    font-family: {$family};
    src: url("{$url}");
    font-weight: {$weight};
    font-style: {$style};
}

EOT;

    }

}
