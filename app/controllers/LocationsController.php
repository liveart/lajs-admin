<?php

class LocationsController extends BaseController {

	protected $location;

	public function __construct(Location $loc)
	{
		$this->location = $loc;
	}

	public function create()
	{
		// pass on the product id into the form
		return View::make('locations.create')->with('product_id',Request::query('product_id'));
	}

	// For new location
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Location::$rules);

		if ($validation->passes())
		{
			$this->location = new Location;
			$this->location->setCoords(array(Input::get('left'),Input::get('top'),Input::get('right'),Input::get('bottom')),'editableArea');
			$this->location->setCoords(array(Input::get('width'),Input::get('height')),'editableAreaUnits');
			$this->location->setCoords(array(Input::get('cr_left'),Input::get('cr_top'),Input::get('cr_right'),Input::get('cr_bottom')),'clipRect');
			$this->location->product_id = Input::get('product_id');
			$this->location->name = Input::get('name');
			// process uploaded image file
			if (Input::hasFile('imageFile')) {
				$suffix = '/'.Input::get('product_id').'/'.Input::get('name');
				$dest = Config::get('app.product_upload_destination').$suffix;
				$pref = Config::get('app.product_upload_path').$suffix;
				if (!File::exists($dest)) {
					File::makeDirectory($dest, 0775, true);
				}
				$file = Input::file('imageFile');
				$file->move($dest, $file->getClientOriginalName());
				$this->location->image = asset($pref.'/'.$file->getClientOriginalName());
			} else {
				$this->location->image = Input::get('image');
			}
			$this->location->save();
			return Redirect::route('products.edit', $this->location->product->id);
		}
		return Redirect::route('locations.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	public function edit($id)
	{
		$location = $this->location->find($id);
		if (is_null($location)) {
			return Redirect::route('products.index');
		}
		$ea = $location->getCoords('editableArea');
		$eau = $location->getCoords('editableAreaUnits');
		$cr = $location->getCoords('clipRect');
		// TODO refactor to array if this is supported
		return View::make('locations.edit', compact('location'))
			->with('left',$ea[0])
			->with('top',$ea[1])
			->with('right',$ea[2])
			->with('bottom',$ea[3])
			->with('width',$eau[0])
			->with('height',$eau[1])
			->with('cr_left',$cr[0])
			->with('cr_top',$cr[1])
			->with('cr_right',$cr[2])
			->with('cr_bottom',$cr[0]);	
	}

	/**
	 * Update the location of certain product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Location::$rules);
        $fields_to_except = array('locationName', 'top', 'left', 'bottom', 'right', 'width', 'height', 'cr_top', 'cr_left', 'cr_bottom', 'cr_right', 'imageFile');
		if ($validation->passes()) {
			$loc = $this->location->find($id);
			$loc->setCoords(array(Input::get('left'),Input::get('top'),Input::get('right'),Input::get('bottom')),'editableArea');
			$loc->setCoords(array(Input::get('width'),Input::get('height')),'editableAreaUnits');
			$loc->setCoords(array(Input::get('cr_left'),Input::get('cr_top'),Input::get('cr_right'),Input::get('cr_bottom')),'clipRect');
            // process uploaded image file
            if (Input::hasFile('imageFile')) {
                $suffix = '/'.$loc->product->id.'/'.Input::get('name');
                $dest = Config::get('app.product_upload_destination').$suffix;
                $pref = Config::get('app.product_upload_path').$suffix;
                if (!File::exists($dest)) {
                    File::makeDirectory($dest, 0775, true);
                }
                $file = Input::file('imageFile');
                $file->move($dest, $file->getClientOriginalName());
                $loc->image = asset($pref.'/'.$file->getClientOriginalName());

                // ignore the URL field if file is uploaded
                array_push($fields_to_except,'image');
            }
			// extract all custom input
            $input = array_except($input, $fields_to_except);
			$loc->update($input);
			// redirect back to parent product
			return Redirect::route('products.edit', $loc->product->id)
				->with('message','Location '.$loc->name.' is updated.');;
		}
		return Redirect::route('locations.edit', $id)
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
		$loc = $this->location->find($id);
		$product_id = $loc->product->id;
		// check if any color locations left
		if (count($loc->pcli)) {
			$msg = '';
			return Redirect::route('products.edit', $product_id)
				->with('error','Location still has Location Image records. Delete them first.');
		} else {
			$loc->delete();
			return Redirect::route('products.edit', $product_id)
				->with('message','Location has been removed.');
		}
	}
	
}