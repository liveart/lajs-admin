<?php

class ColorsController extends BaseController {

	protected $color;

	public function __construct(Color $color)
	{
		$this->color = $color;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$colors = $this->color->whereDoesntHave('products')->orderBy('name','asc')->get();
		return View::make('colors.index', compact('colors'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('colors.create')
        	->with('id',Request::query('id'))
			->with('type',Request::query('type'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Color::$rules);
		if ($validation->passes())
		{
			$cl = $this->color->create(array_except($input, array('of_id','of_type')));
			if ('' !== Input::get('of_id')) {
				// attempt to fetch the product
				$prod = Product::find(Input::get('of_id'));
				$prod->colors()->save($cl);
			}
            switch (Input::get('of_type')) {
                case 'Product':
                    return Redirect::route('products.edit', Input::get('of_id'))
                        ->with('message', 'Color has been created.');
                    break;
            }
			return Redirect::route('colors.index');
		}
		return Redirect::route('colors.create')
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
        return View::make('colors.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$color = $this->color->find($id);
		if (is_null($color))
		{
			return Redirect::route('colors.index');
		}
		return View::make('colors.edit', compact('color'));
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
		$validation = Validator::make($input, Color::$rules);
		if ($validation->passes())
		{
			$color = $this->color->find($id);
			$color->update($input);

            // if colorable product exists, redirect back to such product
			if (count($color->products) > 0) {
                return Redirect::route('products.edit', $color->products[0]->id)
						->with('message', 'Color updated.');
			}
            return Redirect::route('colors.index');
		}
		return Redirect::route('colors.edit', $id)
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
	public function destroy($id) {
		$this->color->find($id)->delete();
		return Redirect::route('colors.index');
	}

	public function toJSON() {
		$json = array();
		// TODO filter out product colors
		$json['colors'] = $this->color->orderBy('name','asc')->get();
		return $json;
	}

}
