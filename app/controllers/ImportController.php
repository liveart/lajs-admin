<?php

class ImportController extends BaseController {

	protected $rules;

	public function __construct()
	{ 
		$this->rules = array(
			'fontsURL' => 'required|url',
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
	 * Import fonts from JSON to DB
	 *
	 * @return Response
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
		// add error messages here
		return View::make('import.index');
	}
}
