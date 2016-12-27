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
        if (Auth::check())
            return redirect('/');
        else
            return view('auth.myregister');
    });
    Route::post('/myregister','MyAuthController@register');

    //check if user is an investor in our database
//    Route::get('/check',function(){
//        return redirect(url('/myregister'));
//    });
//    Route::post('/check','MyAuthController@check');


    //show the page where user can chose where to get the code
    Route::get('/code/destination', function() {
        if (Auth::check() && Auth::user()->status != 'new')
            return redirect('/');
        else
            return view('auth.codeSendChoice');
    });

    //send code to where user has specified
    Route::post('/code/send', 'MyAuthController@sendCode');

//    //show the page where user can enter the code they received
//    Route::get('/activate/{id}','MyAuthController@getActivate');

    Route::get('/code/verify', function () {
        if (Auth::check() && Auth::user()->status != 'new')
            return redirect('/');
        else
            return view('auth.verify');
    });
    //verify the code that user entered to match with database
    //Route::post('/code/verify','MyAuthController@verifyCode');

    //Verify code sent to email
    Route::get('/verify/token/{token}', 'MyAuthController@verifyToken');


    Route::get('/home', 'HomeController@redirect');

    Route::get('/help', 'HomeController@help');

//    Route::get('/password/first','InvestorController@activate');

    Route::post('/password/first', 'InvestorController@resetFirstTimePassword');
    Route::get('/reset/password', 'MyAuthController@reset');

    Route::get('/disabled', function () {
        return view('errors.disabledUser');
    });


});
Route::group(['prefix'=>'investor','middleware'=>['web','auth','investor']],function(){
    Route::get('/','InvestorController@home');
    Route::get('/cars','InvestorController@cars');
    Route::get('/contracts','InvestorController@contracts');
    Route::get('/drivers','InvestorController@drivers');
    Route::get('/cars/{id}','CarController@show');
    Route::post('/cars/{id}/update', 'CarController@update');
    Route::get('/contracts/{id}','ContractController@show');
    Route::get('/drivers/{id}','DriverController@show');

    Route::get('/assets/create/{item}','AssetController@create');
    Route::post('/assets/car/store','AssetController@storeCar');
    Route::post('/assets/contract/store','AssetController@storeContract');
    Route::post('/assets/driver/store','AssetController@storeDriver');

    Route::get('/partial/create/{item}','AssetController@partialCreate');
    Route::get('/show/{id}', 'InvestorController@show');

    Route::post('/support/create', 'InvestorController@messageAdmin');

});

Route::group(['prefix'=>'admin', 'middleware'=>['web','auth','admin']],function(){

    Route::get('/','AdminController@home');

    //INVESTORS//
    Route::get('/investor/all', 'InvestorController@index');

    //show the details page
    Route::get('/investor/show/{id}', 'InvestorController@show');

    //show form page to register a new investor
    Route::get('/investor/create',"InvestorController@create");

    //save the data received from the form into the database
    //create an investor
    //create a user with sample password
    //create email with password reset token
    //send email
    Route::post('/investor/store', 'InvestorController@admin_store');

    //CARS//
    Route::get('/car/all', 'CarController@index');

    //show form to create car
    Route::get('/car/create','CarController@create');

    //save data received
    Route::post('/car/store','CarController@store');

    //DRIVERS//
    Route::get('/driver/all', 'DriverController@index');

    //show form to create driver
    Route::get('/driver/create','DriverController@create');

    //save data received
    Route::post('/driver/store','DriverController@store');


});

Route::group(['prefix' => 'super', 'middleware' => ['web', 'auth', 'super-admin']], function () {
    Route::group(['prefix' => 'api'], function () {
        Route::get('/auth-user', 'MyAuthController@api_authUser');
        Route::get('/all', 'AdminController@api_all');
        Route::get('/{id}', 'AdminController@api_get');
        Route::put('/{id}/update', 'AdminController@api_update');
        Route::get('/{id}/reset', 'AdminController@api_reset_pass');
        Route::get('/{id}/delete', 'AdminController@api_delete');
    });
    Route::post('/user/store', 'AdminController@store');
    Route::get('/admin/all', function () {
        return view('admin.index');
    });
});


Route::group(['prefix'=>'api'],function(){

    //Route::get('/code/{code}/verify','MyAuthController@apiVerifyCode');
    Route::get('/user/match/{text}','ApiController@matchUser');
    Route::get('/user/edit/{id}/status/{value}','ApiController@setActive');
    Route::get('/contract/all','ContractController@all')->middleware('web','auth');
    Route::get('/car/all','CarController@all')->middleware('web','auth');
    Route::get('/driver/all','DriverController@all')->middleware('web','auth');
    Route::get('/drivers', 'DriverController@api_all')->middleware('web', 'auth');

    Route::get('/contract/{id}','ContractController@api_show');
    Route::get('/contract/filter/{search}','ContractController@filterContractsByCarDriver');
    Route::get('/contract/andfilter/{search}','ContractController@filterContractsByCarAndDriver');
    Route::get('/contract/orfilter/{search}','ContractController@filterContractsByCarOrDriver');
    Route::get('/contract/{id}/revenue/summary','ContractController@ContractRevenueSummary');
    Route::get('/contract/{id}/revenue/detail','ContractController@ContractRevenueDetail');

    Route::get('/investor/revenue/summary','InvestorController@RevenueSummary')->middleware('web','auth');
    Route::get('/investor/asset/summary','InvestorController@AssetsSummary')->middleware('web','auth');

    Route::get('/email/test','ApiController@sendMail');
    Route::get('/email/code', 'ApiController@testCodeEmail');
    Route::post('/email/post', 'ApiController@testGuzzlePost');

    Route::group(['prefix' => 'admin'], function () {

        Route::group(['prefix' => 'investors'], function () {
            Route::get('/all', 'InvestorController@api_all');
            Route::get('/{id}', 'InvestorController@api_get');
            Route::put('/{id}/update', 'InvestorController@api_update');
            Route::get('/{id}/revenues', 'InvestorController@api_revenues');
            Route::get('/{id}/cars', 'InvestorController@api_cars');
            Route::get('/{id}/contracts', 'InvestorController@api_contracts');
            Route::get('/{id}/drivers', 'InvestorController@api_drivers');

        });

        Route::group(['prefix' => 'cars'], function () {
            Route::get('/all', 'CarController@api_all');
            Route::get('/{id}', 'CarController@api_get');
            Route::put('/{id}/update', 'CarController@api_update');
            Route::put('/post', 'CarController@api_new');
            Route::get('/{id}/unlink', 'CarController@api_unlink');
            Route::get('/{id}/delete', 'CarController@api_delete');
            // Route for the orders
            Route::group(['prefix' => '{car_id}/orders'], function () {
                Route::get('/','OrderController@index');
                Route::post('/', 'OrderController@store');
                Route::get('/{order_id}', 'OrderController@show');
                Route::put('/{order_id}', 'OrderController@update');
                Route::delete('/{order_id}', 'OrderController@delete');
            });

            // Route for the tickets
            Route::group(['prefix' => '{car_id}/tickets'], function () {
                Route::get('/','TicketController@index');
                Route::post('/', 'TicketController@store');
                Route::get('/{ticket_id}', 'TicketController@show');
                Route::put('/{ticket_id}', 'TicketController@update');
                Route::delete('/{ticket_id}', 'TicketController@delete');
                Route::post('/{ticket_id}/attachment','TicketController@attachmentUpload');
                Route::get('/{ticket_id}/pdf','TicketController@downloadTicketPdf');                
            });
            // Route for the deliveries
            Route::group(['prefix' => '{car_id}/deliveries'], function () {
                Route::get('/', 'DeliveryController@index');
                Route::post('/', 'DeliveryController@store');
                Route::get('/{delivery_id}', 'DeliveryController@show');
                Route::put('/{delivery_id}', 'DeliveryController@update');
                Route::delete('/{delivery_id}', 'DeliveryController@delete');
            });
            Route::group(['prefix' => '{car_id}/suppliers'], function () {
                Route::get('/', 'SupplierController@index');
                Route::post('/', 'SupplierController@store');
                Route::get('/{supplier_id}', 'SupplierController@show');
                Route::put('/{supplier_id}', 'SupplierController@update');
                Route::delete('/{supplier_id}', 'SupplierController@delete');
            });
            Route::group(['prefix' => '{car_id}/cameras'], function () {
                Route::get('/', 'CameraController@index');
                Route::post('/', 'CameraController@store');
                Route::get('/{camera_id}', 'CameraController@show');
                Route::put('/{camera_id}', 'CameraController@update');
                Route::delete('/{camera_id}', 'CameraController@delete');
            });
            Route::group(['prefix' => '{car_id}/trackers'], function () {
                Route::get('/', 'TrackerController@index');
                Route::post('/', 'TrackerController@store');
                Route::get('/{tracker_id}', 'TrackerController@show');
                Route::put('/{tracker_id}', 'TrackerController@update');
                Route::delete('/{tracker_id}', 'TrackerController@delete');
            });
        });
        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/all', 'ContractController@api_all');
            Route::get('/{id}', 'ContractController@api_get');
            Route::put('/{id}/update', 'ContractController@api_update');
            Route::put('/post', 'ContractController@api_new');
            Route::get('/{id}/delete', 'ContractController@api_delete');
        });

        Route::group(['prefix' => 'drivers'], function () {
            Route::get('/all', 'DriverController@api_all');
            Route::get('/{id}', 'DriverController@api_get');
            Route::put('/{id}/update', 'DriverController@api_update');
            Route::put('/post', 'DriverController@api_new');
            Route::get('/{id}/delete', 'DriverController@api_delete');
            Route::post('/{id}/attachment','DriverController@attachmentUpload');
            Route::get('/{id}/pdf','DriverController@downloadFullPDF');

        });

        Route::group(['prefix' => 'revenues'], function () {
            Route::get('/all', 'RevenueController@api_all');
            Route::get('/{id}', 'RevenueController@api_get');
            Route::put('/{id}/update', 'RevenueController@api_update');
            Route::put('/post', 'RevenueController@api_new');
            Route::get('/{id}/delete', 'RevenueController@api_delete');
        });

        Route::group(['prefix' => 'policies'], function () {
                Route::post('/', 'PolicyController@store');
                Route::get('/{policy_id}', 'PolicyController@show');
                Route::put('/{policy_id}', 'PolicyController@update');
                Route::delete('/{policy_id}', 'PolicyController@delete');
                Route::post('/{policy_id}/attachment','PolicyController@attachmentUpload');
        });
    });
});
