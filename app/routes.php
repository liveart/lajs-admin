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

// Route to show the login form
Route::get('login', 'HomeController@showLogin');
Route::post('login', 'HomeController@doLogin');
Route::get('logout', 'HomeController@doLogout');

// Routes that require login
Route::group(array('before' => 'auth'), function() {

    // All resources go here
    Route::resource('products', 'ProductsController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('locations', 'LocationsController');

    // for ability to delete from nested forms
    Route::get('colorizableElements/{id}/delete', array('as'=>'colorizableElements.delete','uses'=>'ColorizableElementsController@destroy'));
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

});

// JSON Routes
Route::get('/api/products', 'ProductsController@toJSON');
Route::get('/api/graphics', 'GraphicsItemsController@toJSON');
Route::get('/api/fonts', 'FontsController@toJSON');
Route::get('/api/colors', 'ColorsController@toJSON');

// CSS Routes
Route::get('api/fontscss', 'FontsController@getCSS');