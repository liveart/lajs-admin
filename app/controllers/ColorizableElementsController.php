<?php

class ColorizableElementsController extends BaseController {

	/**
	 * ColorizableElement Repository
	 *
	 * @var ColorizableElement
	 */
	protected $colorizableElement;

	public function __construct(ColorizableElement $colorizableElement)
	{
		$this->colorizableElement = $colorizableElement;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$colorizableElements = $this->colorizableElement->all();
		return View::make('colorizableElements.index', compact('colorizableElements'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// type would be either graphic or product
		return View::make('colorizableElements.create')
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
		$validation = Validator::make($input, ColorizableElement::$rules);

		if ($validation->passes())
		{
			// TODO redirect back to originated page
			$this->colorizableElement->create($input);
			return Redirect::route('colorizableElements.index');
		}
		return Redirect::route('colorizableElements.create')
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
		$colorizableElement = $this->colorizableElement->findOrFail($id);
		return View::make('colorizableElements.show', compact('colorizableElement'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$colorizableElement = $this->colorizableElement->find($id);
		if (is_null($colorizableElement))
		{
			return Redirect::route('colorizableElements.index');
		}
		return View::make('colorizableElements.edit', compact('colorizableElement'));
	}

	/**
	 * Add color to colorizable element
	 *
	 */
	public function attachColor($id, $color_id) {
		$el = $this->colorizableElement->find($id);
		$color = Color::find($color_id);
		$el->colors()->save($color);
		return Redirect::route('colorizableElements.edit', $id)
			->withInput()
			->with('message', 'Color was added.');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), array('_method','color_ids'));
		$validation = Validator::make($input, ColorizableElement::$rules);

		if ($validation->passes())
		{
			$colorizableElement = $this->colorizableElement->find($id);
            if (empty(Input::get('color_ids'))) {
                $colorizableElement->colors()->sync(array());
            } else {
                $colorizableElement->colors()->sync(Input::get('color_ids'));
            }
			$colorizableElement->update($input);
			switch ($colorizableElement->of_type) {
				case 'Product':
					return Redirect::route('products.edit', $colorizableElement->of_id)
						->with('message', 'Colorizable element was updated.');
					break;
				case 'GraphicsItem':
					return Redirect::route('graphicsItems.edit', $colorizableElement->of_id)
						->with('message', 'Colorizable element was updated.');
					break;
				default:
					return Redirect::route('colorizableElements.index');
					break;
			}
			return Redirect::route('colorizableElements.show', $id);
		}

		return Redirect::route('colorizableElements.edit', $id)
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
		$this->colorizableElement->find($id)->delete();

		return Redirect::route('colorizableElements.index');
	}

}
