<?php

class ProductsController extends BaseController {

	/**
	 * Product Repository
	 *
	 * @var Product
	 */
	protected $product;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = $this->product->all();

		return View::make('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('products.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Product::$rules);

		if ($validation->passes())
		{
			$this->product->create($input);
			return Redirect::route('products.index');
		}

		return Redirect::route('products.create')
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
		$product = $this->product->findOrFail($id);

		return View::make('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = $this->product->find($id);
		if (is_null($product))
		{
			return Redirect::route('products.index');
		}
		return View::make('products.edit', compact('product'));
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
		$validation = Validator::make($input, Product::$rules);
		if ($validation->passes())
		{
			$product = $this->product->find($id);
			// process all checkbox values
			$chks = array('multicolor','resizable','showRuler','namesNumbersEnabled');
			foreach ($chks as $chk) {
				$product->setAttribute($chk, (Input::has($chk)) ? true : false);
			}
			$product->update($input);

			return Redirect::route('products.index');
		}
		return Redirect::route('products.edit', $id)
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
		$this->product->find($id)->delete();
		return Redirect::route('products.index');
	}

	public function toJSON() {
		$json = array();
		$cats = Category::all();
		$json['productCategoriesList'] = $cats;
		foreach ($cats as $cat) {
			$cat['products'] = Product::where('categoryId','=',$cat->id)->get();
			// adjust attributes for proper schema
			$atts = array('multicolor','resizable','showRuler','namesNumbersEnabled');
			foreach ($cat['products'] as $prod) {
				foreach ($atts as $att) {
					$prod->setAttribute($att, ($prod->getAttribute($att)=="on"));
				}
				$prod['locations'] = Location::where('product_id','=',$prod->id)->get();
				foreach ($prod['locations'] as $loc) {
					$loc->editableArea = $loc->getCoords('editableArea');
					$loc->editableAreaUnits = $loc->getCoords('editableAreaUnits');
					$loc->clipRect = $loc->getCoords('clipRect');
				}
				// TODO colors
				// TODO colorizableElements
				// TODO check multicolor is set if colorizableelements present
				$prod['sizes'] = explode(',', $prod['sizes']);
			}
		}
		return $json;
	}

}
