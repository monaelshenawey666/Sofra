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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['namespace' => 'Front'], function () {
    Route::get('/', 'MainController@home');
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function () {
        Route::get('register', 'AuthController@registerClient');
        Route::post('registerSave', 'AuthController@registerSaveClient');
        Route::get('login', 'AuthController@clientLogin');
        Route::post('loginSave', 'AuthController@clientLoginSave')->name('clientLoginSave');
        Route::get('logout', 'AuthController@clientLogout');

        Route::group(['middleware' => 'auth:client-web'], function () {
            Route::get('update-account/{id}', 'AuthController@updatClientAccount');
            Route::put('update-account/{id}', 'AuthController@updatClientAccountSave');

            Route::post('password-reset', 'AuthController@resetPassword');
            Route::post('new-password', 'AuthController@newpassword');
        });
        Route::get('cart', 'MainController@cart');

    });


    Route::group(['prefix' => 'resturant'], function () {
        Route::group(['namespace' => 'Resturant'], function () {
            Route::get('register', 'AuthController@registerResturant');
            Route::post('registerSave', 'AuthController@registerSaveResturant');
            Route::get('login', 'AuthController@resturantLogin');
            Route::post('loginSave', 'AuthController@resturantLoginSave')->name('resturantLoginSave');
            Route::get('logout', 'AuthController@resturantLogout');
        });
        Route::group(['middleware' => 'auth:restaurant-web', 'namespace' => 'Resturant'], function () {
            Route::get('my-products', 'MainController@myProducts');
            Route::get('add-new-product', 'MainController@addNewProduct');
            Route::post('add-new-product-save', 'MainController@addNewProductSave');
            Route::get('my-offers', 'MainController@myOffers');
            Route::get('add-new-offer', 'MainController@addNewOffer');
            Route::post('add-new-offer-save', 'MainController@addNewOfferSave');
            Route::get('current-orders', 'MainController@currentorders');
            Route::get('previous-orders', 'MainController@previoustorders');

            Route::get('update-account', 'AuthController@updatResturantAccount');
            Route::post('update-account-save', 'AuthController@updatResturantAccountSave');
            //Route::post('password/reset/{id}','AuthController@resetpassword')->name('password.reset');
            // Route::post('newpassword','AuthController@newpassword');

        });
        Route::get('details/{id}', 'MainController@resturantDetails');
        Route::get('product-details/{id}', 'MainController@productDetails');
        Route::get('all-offers', 'MainController@allOffers');

    });
    Route::get('contact-us', 'MainController@contactUs');
    Route::post('contact-us-save', 'MainController@contactUsSave');
    Route::get('rates', 'MainController@ratesAverage');


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'HomeController@logout');

Route::group(['middleware' => ['auth', 'auto-check-permission'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
//    Route::get('/','HomeController@index');
    Route::resource('resturant', 'ResturantController');
    Route::get('resturant/{id}/activate', 'ResturantController@activate');
    Route::get('resturant/{id}/de-activate', 'ResturantController@deActivate');
    Route::resource('category', 'CategoryController');
    Route::resource('transaction', 'TransactionController');
    Route::resource('order', 'OrderController');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('offer', 'OfferController');
    Route::resource('client', 'ClientController');
    Route::resource('contact', 'ContactController');
    Route::resource('settings', 'SettingsController');
    Route::resource('payment-method', 'PaymentMethodController');

    Route::get('user/change-password', 'UserController@changePassword');
    Route::post('user/change-password', 'UserController@changePasswordSave');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');


});
