<?php

class ProductColorLocationsController extends BaseController {

	protected $pcli;

	public function __construct(Pcli $pcli)
	{
		$this->pcli = $pcli;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Pcli::$rules);

		if ($validation->passes())
		{
			$this->pcli->create($input);
			return Redirect::route('products.edit', $input['product_id'])
				->with("message","The location image has been added.");
		}

		return Redirect::route('products.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the PCLI from product and redirect back to the product
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pcli = $this->pcli->find($id);
		$product_id = $pcli->product->id;
		$pcli->delete();
		return Redirect::route('products.edit', $product_id)
			->with("message","The location image has been removed.");
	}

}
