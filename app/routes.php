<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('products', 'ProductsController');
	Route::resource('categories', 'CategoriesController');
	Route::resource('locations', 'LocationsController');
	Route::resource('colorizableElements', 'ColorizableElementsController');
	Route::resource('pclis', 'ProductColorLocationsController');
Route::resource('graphicsCategories', 'GraphicsCategoriesController');
	Route::resource('graphicsItems', 'GraphicsItemsController');
Route::resource('fonts', 'FontsController');
Route::resource('colors', 'ColorsController');

// Import
Route::get('import','ImportController@showIndex');
Route::post('import','ImportController@importFonts');
Route::post('import','ImportController@importGraphics');

// JSON Routes
Route::get('/api/products', 'ProductsController@toJSON');
Route::get('/api/graphics', 'GraphicsItemsController@toJSON');
Route::get('/api/fonts', 'FontsController@toJSON');
Route::get('/api/colors', 'ColorsController@toJSON');