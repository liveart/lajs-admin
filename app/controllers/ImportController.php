<?php

class ImportController extends BaseController {

	protected $rules;

	public function __construct()
	{ 
		$this->rules = array(
			'fontsURL' => 'required|url',
			'graphicsURL' => 'required|url',
		);
	}

	/**
	 * Show main import form.
	 *
	 * @return Response
	 */
	public function showIndex()
	{
        return View::make('import.index');
	}

	/**
	 * Import graphic gallery from JSON
	 * 
	 */
	public function importGraphics() {
		$input = Input::all();
		$v = Validator::make($input, $this->rules);

		if ($v->passes()) {
			$url = Input::get('graphicsURL');
			$json = file_get_contents($url); 
			$data = json_decode($json);
			$atts = array('name','description','colors');
			foreach ($data->graphicsCategoriesList as $row) {
				$cat = new GraphicsCategory;
				$cat->name = $row->name;
				$cat->save();
				foreach ($row->graphicsList as $g) {
					$graphic = new GraphicsItem;
					$graphic->category = $cat;
					$graphic->name = $g->name;
					$graphic->description = $g->description;
					$graphic->thumb = $g->thumb;
					$graphic->image = $g->image;
					// optional atts block
					if (property_exists($g, 'colors')) {
						$graphic->colors = intval($g->colors);
					}
					if (property_exists($g, 'multicolor')) {
						$graphic->multicolor = $g->multicolor;
					}
					// "colorize": true - would be a synthesized att,
					// so we are not importing it
					$graphic->save();
					if (property_exists($g, 'colorizableElements')) {
						foreach ($g->colorizableElements as $ce) {
							$el = new ColorizableElement;
							$el->name = $ce->name;
							$el->css_id = $ce->id;
							$el->colorizable = $graphic;
							// if needed add colors import here
							$el->save();
						}
					}
				}
			}
			return Redirect::route('graphicsItems.index')->with('message','Gallery was imported!');
		}
		// TODO add error messages here when necessary
		return View::make('import.index');
	}


	/**
	 * Import fonts from JSON to DB
	 *
	 * @return redirects to imported data page
	 */
	public function importFonts()
	{
		$input = Input::all();
		$v = Validator::make($input, $this->rules);

		if ($v->passes()) {
			$url = Input::get('fontsURL');
			$json = file_get_contents($url); 
			$data = json_decode($json);
			// atts to import
			$atts = array('name','fontFamily','ascent','vector','boldAllowed','italicAllowed');
			foreach ($data->fonts as $row) {
				$font = new Font;
				foreach ($atts as $att) {
					if (property_exists($row, $att)) {
						$font->$att = $row->$att;
					}
				}
				$font->save();
			}
			return Redirect::route('fonts.index')->with('message','Fonts were imported!');
		}
		// TODO add error messages here
		return View::make('import.index');
	}
}
