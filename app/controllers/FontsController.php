<?php

class FontsController extends BaseController {

	/**
	 * Font Repository
	 *
	 * @var Font
	 */
	protected $font;

	public function __construct(Font $font)
	{
		$this->font = $font;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fonts = $this->font->all()->sortBy('name');

		return View::make('fonts.index', compact('fonts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('fonts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Font::$rules);

		if ($validation->passes())
		{
			$this->font->create($input);

			return Redirect::route('fonts.index');
		}

		return Redirect::route('fonts.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$font = $this->font->findOrFail($id);

		return View::make('fonts.show', compact('font'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$font = $this->font->find($id);

		if (is_null($font))
		{
			return Redirect::route('fonts.index');
		}

		return View::make('fonts.edit', compact('font'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Font::$rules);

		if ($validation->passes())
		{
			$font = $this->font->find($id);
			$chks = array('boldAllowed','italicAllowed');
			foreach ($chks as $chk) {
				$font->setAttribute($chk, (Input::has($chk)) ? true : false);
			}
			$font->update($input);

			return Redirect::route('fonts.index');
		}

		return Redirect::route('fonts.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->font->find($id)->delete();

		return Redirect::route('fonts.index');
	}

	public function toJSON() {
		return $this->font->getJSON();
	}

    public function getCSS() {
		return Response::make($this->font->getCSS())->header('Content-Type', 'text/css');
    }

}
