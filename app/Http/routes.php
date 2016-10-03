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
    Route::post('/myregister','MyAuthController@register');

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


    Route::get('/home', 'HomeController@redirect');

    Route::get('/activate/email/{token}','InvestorController@activate');

    Route::post('/password/first','InvestorController@resetFirstTimePassword');

});
Route::group(['prefix'=>'investor','middleware'=>['web','auth','investor']],function(){
    Route::get('/','InvestorController@home');
    Route::get('/cars','InvestorController@cars');
    Route::get('/contracts','InvestorController@contracts');
    Route::get('/drivers','InvestorController@drivers');
    Route::get('/cars/{id}','CarController@show');
    Route::get('/contracts/{id}','ContractController@show');
    Route::get('/drivers/{id}','DriverController@show');

    Route::get('/assets/create/{item}','AssetController@create');
    Route::post('/assets/car/store','AssetController@storeCar');
    Route::post('/assets/contract/store','AssetController@storeContract');
    Route::post('/assets/driver/store','AssetController@storeDriver');

    Route::get('/partial/create/{item}','AssetController@partialCreate');


});

Route::group(['prefix'=>'admin', 'middleware'=>['web','auth','admin']],function(){
    //ADMINS//
    Route::get('/','AdminController@home');

    //list all admins
    Route::get('/list','AdminController@index');

    Route::get('/edit/{id}','AdminController@edit');

    //update details for investor
    Route::put('/edit/{id}','AdminController@update');


    //show form where registration can be done for admins (BY SUPER ADMIN ONLY)
    Route::get('/create','AdminController@create');

    //save data to create new user with admin rights or create one
    Route::post('/store','AdminController@store');

    //INVESTORS//
    Route::get('/investor','InvestorController@index');

    //show form page to register a new investor
    Route::get('/investor/create',"InvestorController@create");

    //save the data received from the form into the database
    //create an investor
    //create a user with sample password
    //create email with password reset token
    //send email
    Route::post('/investor/store','InvestorController@store');

    //CARS//
    Route::get('/car','CarController@index');

    //show form to create car
    Route::get('/car/create','CarController@create');

    //save data received
    Route::post('/car/store','CarController@store');

    //DRIVERS//
    Route::get('/driver','DriverController@index');

    //show form to create driver
    Route::get('/driver/create','DriverController@create');

    //save data received
    Route::post('/driver/store','DriverController@store');


});



Route::group(['prefix'=>'api'],function(){

    Route::get('/code/{code}/verify','MyAuthController@apiVerifyCode');
    Route::get('/user/match/{text}','ApiController@matchUser');
    Route::get('/user/edit/{id}/status/{value}','ApiController@setActive');
    Route::get('/contract/all','ContractController@all')->middleware('web','auth');
    Route::get('/car/all','CarController@all')->middleware('web','auth');
    Route::get('/driver/all','DriverController@all')->middleware('web','auth');

    Route::get('/contract/{id}','ContractController@api_show');
    Route::get('/contract/filter/{search}','ContractController@filterContractsByCarDriver');
    Route::get('/contract/andfilter/{search}','ContractController@filterContractsByCarAndDriver');
    Route::get('/contract/orfilter/{search}','ContractController@filterContractsByCarOrDriver');
    Route::get('/contract/{id}/revenue/summary','ContractController@ContractRevenueSummary');
    Route::get('/contract/{id}/revenue/detail','ContractController@ContractRevenueDetail');

    Route::get('/investor/revenue/summary','InvestorController@RevenueSummary')->middleware('web','auth');
    Route::get('/investor/asset/summary','InvestorController@AssetsSummary')->middleware('web','auth');

    Route::get('/email/test','ApiController@sendMail');



});
