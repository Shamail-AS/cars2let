<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/myregister', function () {
        return view('auth.myregister');
    });

    //check if user is an investor in our database
    Route::get('/check',function(){
        return redirect(url('/myregister'));
    });
    Route::post('/check','MyAuthController@check');

    //show the page where user can chose where to get the code
    Route::get('/code/destination', function() {
       return view('auth.codeSendChoice');
    });

    //send code to where user has specified
    Route::post('/code/send', 'MyAuthController@sendCode');

    //verify the code that user entered to match with database
    Route::post('/code/verify','MyAuthController@verifyCode');

    //show the page where user can enter the code they received
    Route::get('/activate/{id}','MyAuthController@getActivate');


    Route::get('/home', 'HomeController@index');

    Route::get('/activate/email/{token}','InvestorController@activate');

    Route::post('/password/first','InvestorController@resetFirstTimePassword');

});

Route::group(['prefix'=>'admin'],function(){

    //show form page to register a new investor
    Route::get('/investor/create',"InvestorController@create");

    //save the data received from the form into the database
    //create an investor
    //create a user with sample password
    //create email with password reset token
    //send email
    Route::post('/investor/store','InvestorController@store');

    Route::get('/investor','InvestorController@index');
});

Route::group(['prefix'=>'api'],function(){

    Route::get('/code/{code}/verify','MyAuthController@apiVerifyCode');

});
