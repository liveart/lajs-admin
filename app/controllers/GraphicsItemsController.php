<?php

class GraphicsItemsController extends BaseController {

	/**
	 * GraphicsItem Repository
	 *
	 * @var GraphicsItem
	 */
	protected $graphicsItem;

	public function __construct(GraphicsItem $graphicsItem)
	{
		$this->graphicsItem = $graphicsItem;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$graphicsItems = $this->graphicsItem->all();

		return View::make('graphicsItems.index', compact('graphicsItems'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('graphicsItems.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, GraphicsItem::$rules);

		if ($validation->passes())
		{
			$this->graphicsItem->create($input);

			return Redirect::route('graphicsItems.index');
		}

		return Redirect::route('graphicsItems.create')
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
		$graphicsItem = $this->graphicsItem->findOrFail($id);

		return View::make('graphicsItems.show', compact('graphicsItem'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$graphicsItem = $this->graphicsItem->find($id);

		if (is_null($graphicsItem))
		{
			return Redirect::route('graphicsItems.index');
		}

		return View::make('graphicsItems.edit', compact('graphicsItem'));
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
		$validation = Validator::make($input, GraphicsItem::$rules);

		if ($validation->passes())
		{
			$graphicsItem = $this->graphicsItem->find($id);
			$graphicsItem->update($input);

			return Redirect::route('graphicsItems.show', $id);
		}

		return Redirect::route('graphicsItems.edit', $id)
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
		$this->graphicsItem->find($id)->delete();

		return Redirect::route('graphicsItems.index');
	}

	public function toJSON() {
		return $this->graphicsItem->getJSON();
	}

}
