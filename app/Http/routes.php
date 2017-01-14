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
    Route::get('images/app/tickets/{filename}', 'SiteFileController@getTicketFile');
    Route::get('images/app/handovers/{filename}', 'SiteFileController@getHandoverFile');
    Route::get('images/app/driver/{driver_id}/{filename}', 'SiteFileController@getDriverFile');
    Route::get('images/app/car/{car_id}/{filename}', 'SiteFileController@getCarFile');
    Route::get('images/app/accidents/{filename}', 'SiteFileController@getAccidentFile');

    Route::get('/myregister', function () {
        if (Auth::check())
            return redirect('/');
        else
            return view('auth.myregister');
    });
    Route::post('/myregister','MyAuthController@register');

    //show the page where user can chose where to get the code
    Route::get('/code/destination', function() {
        if (Auth::check() && Auth::user()->status != 'new')
            return redirect('/');
        else
            return view('auth.codeSendChoice');
    });

    //send code to where user has specified
    Route::post('/code/send', 'MyAuthController@sendCode');
    Route::get('/code/verify', function () {
        if (Auth::check() && Auth::user()->status != 'new')
            return redirect('/');
        else
            return view('auth.verify');
    });
    //Verify code sent to email
    Route::get('/verify/token/{token}', 'MyAuthController@verifyToken');
    Route::get('/home', 'HomeController@redirect');
    Route::get('/help', 'HomeController@help');

    Route::post('/password/first', 'InvestorController@resetFirstTimePassword');
    Route::get('/reset/password', 'MyAuthController@reset');

    Route::get('/disabled', function () {
        return view('errors.disabledUser');
    });

    //FOR Driver Registration As an individual
    Route::get('drivers/new/', 'DriverController@viewDriverRegistrationForm');
    Route::post('drivers/store', 'DriverController@storeDriver');

    // For cars listing with pictures .. 
    Route::get('cars/list','CarController@listOfCars');
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

    Route::get('/car/{id}', 'CarController@admin_show');
    Route::get('/car/{id}/view/{page}', 'CarController@view');
    Route::get('/car/{id}/pictures','CarController@pictureUploadView');
    Route::post('/car/{id}/upload','CarController@attachmentUpload');

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

    //TICKETS
    Route::get('tickets/{ticket_id}', 'TicketController@show');
    Route::post('tickets/{ticket_id}/attach', 'TicketController@attach');

    //SUPPLIERS
    Route::get('suppliers/all', 'SupplierController@api_all');

    //TODO: replace uses of this route with the one under api group - deprecate this
    Route::get('suppliers/for/{type}', 'SupplierController@api_list');

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
    Route::get('/pdf/test', 'ApiController@testPDF');
    Route::get('/pdf/{view}', 'ApiController@testPDFView');
    Route::get('/email/code', 'ApiController@testCodeEmail');
    Route::post('/email/post', 'ApiController@testGuzzlePost');
    Route::get('/phpinfo', function () {
        return phpinfo();
    });

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
        // Route for the orders
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/','OrderController@index');
            Route::post('/', 'OrderController@store');
        });
        Route::group(['prefix' => 'service_orders'], function () {
            Route::get('/','ServiceOrderController@index');
            Route::post('/', 'ServiceOrderController@store');
        });
        // Route for the tickets
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/','TicketController@index');
            Route::post('/', 'TicketController@store');
            Route::get('/infer_driver/{car}/{date}', 'TicketController@inferDriver');
        });
        Route::group(['prefix' => 'deliveries'], function () {
                Route::get('/', 'DeliveryController@index');
                Route::post('/', 'DeliveryController@store');
        });
        Route::group(['prefix' => 'suppliers'], function () {
                Route::get('/', 'SupplierController@index');
                Route::post('/', 'SupplierController@store');
        });

        Route::group(['prefix' => 'cameras'], function () {
                Route::get('/', 'CameraController@index');
                Route::post('/', 'CameraController@store');
        });
        Route::group(['prefix' => 'accidents'], function () {
                Route::get('/', 'AccidentController@index');
                Route::post('/', 'AccidentController@store');
        });

        Route::group(['prefix' => 'cars'], function () {
            Route::get('/all', 'CarController@api_all');
            Route::get('/{id}', 'CarController@api_get');
            Route::put('/{id}/update', 'CarController@api_update');
            Route::put('/{id}/update/selective', 'CarController@api_selective_update');
            Route::put('/post', 'CarController@api_new');
            Route::get('/{id}/delete', 'CarController@api_delete');
            Route::get('/{id}/overview', 'CarController@api_overview');

            // Route for the orders
            Route::group(['prefix' => '{car_id}/orders'], function () {
                Route::get('/','OrderController@index');
                Route::post('/', 'OrderController@store');
                Route::get('/{order_id}', 'OrderController@show');
                Route::put('/{order_id}', 'OrderController@update');
                Route::delete('/{order_id}', 'OrderController@delete');
            });
            Route::group(['prefix' => '{car_id}/service_orders'], function () {
                Route::get('/','ServiceOrderController@index');
                Route::post('/', 'ServiceOrderController@store');
                Route::get('/{service_order_id}', 'ServiceOrderController@show');
                Route::put('/{service_order_id}', 'ServiceOrderController@update');
                Route::delete('/{service_order_id}', 'ServiceOrderController@delete');
            });

            // Route for the tickets
            Route::group(['prefix' => '{car_id}/tickets'], function () {
                Route::get('/','TicketController@index');
                Route::post('/', 'TicketController@store');
                Route::get('/{ticket_id}', 'TicketController@api_get');
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

            Route::group(['prefix' => '{car_id}/accidents'], function () {
                Route::get('/', 'AccidentController@index');
                Route::post('/', 'AccidentController@store');
                Route::get('/{accident_id}', 'AccidentController@show');
                Route::put('/{accident_id}', 'AccidentController@update');
                Route::delete('/{accident_id}', 'AccidentController@delete');
                Route::post('/{accident_id}/attachment','AccidentController@attachmentUpload');
                Route::get('/{accident_id}/pdf','AccidentController@downloadAccidentPdf');                
                
            });
        });

        Route::group(['prefix' => 'sims'], function () {
            Route::get('/', 'SimController@index');
            Route::post('/', 'SimController@store');
            Route::get('/{sim_id}', 'SimController@show');
            Route::put('/{sim_id}', 'SimController@update');
            Route::delete('/{sim_id}', 'SimController@delete');
        });
        Route::group(['prefix' => 'part_orders'], function () {
            Route::get('/all', 'PartOrderController@api_all');
            Route::get('/{id}/deliveries', 'PartOrderController@api_deliveries');
            Route::get('/{id}', 'PartOrderController@api_get');
            Route::put('/{id}', 'PartOrderController@api_update');
            Route::post('/{item_type}/{id}', 'PartOrderController@api_new');
        });
        Route::group(['prefix' => 'part_deliveries'], function () {
            Route::get('/all', 'PartDeliveryController@api_all');
            Route::get('/{id}', 'PartDeliveryController@api_get');
            Route::put('/{id}', 'PartDeliveryController@api_update');
            Route::post('/{order_id}', 'PartDeliveryController@api_new');
        });

        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/all', 'ContractController@api_all');
            Route::get('/{id}', 'ContractController@api_get');
            Route::put('/{id}/update', 'ContractController@api_update');
            Route::put('/post', 'ContractController@api_new');
            Route::get('/{id}/delete', 'ContractController@api_delete');
            Route::get('/{id}/detail', 'ContractController@api_show');
            Route::get('/{id}/revenues', 'ContractController@api_revenues');
            Route::get('/{id}/action/{action}', 'ContractController@api_action');
            Route::post('/{id}/pdf','ContractController@downloadFullPDF');
            Route::get('/{id}/approve','ContractController@contractApproval');
            Route::group(['prefix' => '{contract_id}/handovers', 'middleware' => ['web', 'auth']], function () {
                Route::get('/', 'ContractHandoverController@index');
                Route::get('/create','ContractHandoverController@create');
                Route::post('/', 'ContractHandoverController@store');
                Route::get('/{handover_id}', 'ContractHandoverController@show');
                Route::put('/{handover_id}', 'ContractHandoverController@update');
                Route::delete('/{handover_id}', 'ContractHandoverController@delete');
                Route::post('/{handover_id}/attachment','ContractHandoverController@attachmentUpload');
                Route::get('/{handover_id}/pdf','ContractHandoverController@downloadTicketPdf');                
                
            });
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
            Route::put('/update/allocations', 'RevenueController@api_update_allocations');
            Route::put('/post', 'RevenueController@api_new');
            Route::get('/{id}/delete', 'RevenueController@api_delete');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::get('/contract/{contract_id}', 'PaymentController@getContractPayments');
            Route::post('/contract', 'PaymentController@payContract')->middleware('web', 'auth');
        });

        Route::group(['prefix' => 'policies'], function () {
                Route::post('/', 'PolicyController@store');
                Route::get('/{policy_id}', 'PolicyController@show');
                Route::put('/{policy_id}', 'PolicyController@update');
                Route::delete('/{policy_id}', 'PolicyController@delete');
                Route::post('/{policy_id}/attachment','PolicyController@attachmentUpload');
        });

        Route::group(['prefix' => 'suppliers'], function () {
            Route::get('/all', 'SupplierController@api_all');
            //Route::get('suppliers/all', 'SupplierController@api_all');
            Route::get('/for/{type}', 'SupplierController@api_list');
        });
    });
});
