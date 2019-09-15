<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\country;
use App\User;
use App\state;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('states/{id}', function($id){
	$states = App\state::where('country_id', '=', $id)->get();
	return $states;
});

Route::get('builder-practice', function(){

	//pluk
	// return country::pluck('name');

	//chunk
	// $countries = country::chunk('30', function($countries){
	// 	return $countries;
	// });
	// return response()->json($countries);

	// if exist
	// return response()->json(country::where('id', '=', 1)->exists());

	//select
	// return country::select('name', 'code as country_code')->get();

	//distinct
	// return state::select('country_id')->distinct()->get();

	//add select
	// $query = country::select('name');
	// return $query->addSelect('code')->get();

	// Joins
	// return country::join('states', 'countries.id', '=', 'states.country_id')
	// 		->select('states.name', 'countries.code')
	// 		->get();

	//where
	// return state::where('country_id', 1)->get();
	// return country::join('states', 'countries.id', '=', 'states.country_id')
	// 		->select('states.name', 'countries.code')
	// 		->where('countries.name', 'Pakistan')
	// 		->get();

	//groupBy
	// return state::select('name', 'country_id')->groupBy('country_id')->get();

	//paginate
	$countries = country::paginate(15);
	return $countries;
	// $countries->$users->withPath('custom/url');
});

Route::get('/download', 'fileController@download');

Route::get('/directory/{directory}/image/{name}', 'HomeController@imgShow')->name('image');
