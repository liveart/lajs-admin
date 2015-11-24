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
			$el = $this->colorizableElement->create($input);
			return $this->redirect($el->of_type, $el->of_id);
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
            if (!Input::exists('color_ids')) {
                $colorizableElement->colors()->detach();
            } else {
                $colorizableElement->colors()->sync(Input::get('color_ids'));
            }
			$colorizableElement->update($input);
			return $this->redirect($colorizableElement->of_type, $colorizableElement->of_id);
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
		/** @var ColorizableElement $el */
		$el = $this->colorizableElement->find($id);
		$_type = $el->of_type;
		$_id = $el->of_id;
		$el->delete();

		return $this->redirect($_type, $_id);
	}

	/**
	 * Redirect to correct master record after certain action
	 * @param $type
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	private function redirect($type, $id)
	{
		switch ($type) {
			case 'Product':
				return Redirect::route('products.edit', $id)
					->with('message', 'Colorizable element was updated.');
				break;
			case 'GraphicsItem':
				return Redirect::route('graphicsItems.edit', $id)
					->with('message', 'Colorizable element was updated.');
				break;
			default:
				return Redirect::route('colorizableElements.index');
				break;
		}
	}

}
