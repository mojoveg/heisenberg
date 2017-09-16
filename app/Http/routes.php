<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('about', function () {
    return view('about');
})->name('about');


Route::get('/DCimportAccounts', [
	'uses' => 'DinersClubController@importAccounts',
	'as' => 'DCimportAccounts'
]);

Route::get('/testccs', [
	'uses' => 'testccsController@test',
	'as' => 'testccs'
]);

Route::get('/test1', [
	'uses' => 'testController@test1',
	'as' => 'test1'
]);

Route::auth();

Route::get('/home', 'HomeController@index');


Route::get('testCC', function(){ return view('testCC');});

Route::get('testCCcv', 'testController@testCC');


Route::get('printDump', function () { 
	// return view('printDump', ['reply' => '']); 
	return view('printDump'); 
})->name('printDump');

Route::get('testRedirect', 'testController@testRedirect' );

// Route::get('gambino', function(){ return view('gambino/index');});

// Route::get('gambino', [
// 	'uses' => 'testController@gambino',
// 	'as' => 'gambino'
// ]);

Route::get('gambino', [
	'uses' => 'testController@gambinoPost',
	'as' => 'gambino'
]);

Route::post('gambino', [
	'uses' => 'testController@gambinoPost',
	'as' => 'gambino'
]);

Route::post('gambino2', 'testController@gambino2');

Route::get('gambino2', 'testController@gambino2');

Route::get('gambino3', 'testController@gambino3');

Route::get('gambino4', 'testController@gambino4');

Route::post('gambino3/bill', 'testController@gambino3Bill');

Route::get('lol', function () {
    return view('lol.index');
})->name('lol');