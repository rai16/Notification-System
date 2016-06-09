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

 	//route for the home page
  	Route::get('/', function () {
	
    return view('auth');
	});

	//routes to check whether login and register are valid or not
	Route::post('verify_login','UsersController@verify_login');

	Route::post('verify_register','UsersController@verify_register');

	// route of users/admin/id 
	Route::get('users/admin/{id}', 'UsersController@show');
	//to view history f notifications
	Route::get('users/admin/{id}/history', 'NotifController@history');
	//to send a notification
	Route::post('users/admin/{id}/send', 'NotifController@send');

//routes for users/normal/id to display all the notifications sent to the user
	Route::get('users/normal/{id}', 'NotifController@show');
  

//	if a user click on logout
	Route::get('logout', 'UsersController@logout');

 

