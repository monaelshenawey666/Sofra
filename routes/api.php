<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' =>'v1','namespace'=>'Api'],function(){

    Route::get('categories','MainController@categories');
    Route::get('cities','MainController@cities');
    Route::get('regions','MainController@regions');
    Route::get('resturants','MainController@resturants');
    Route::get('resturant','MainController@resturant');
    Route::post('contact','MainController@contact');
    Route::get('settings','MainController@settings');
    Route::get('restaurant/reviews','MainController@reviews');

    //Route::get('new-offers','MainController@latestOffers');
    Route::get('offers','MainController@offers');
    Route::get('offer','MainController@offer');

    Route::get('products','MainController@products');;
    Route::get('payment-methods','MainController@paymentMethods');



    Route::group(['prefix' =>'resturant'],function() {
        Route::post('sign-up', 'Resturant\AuthController@register');
        Route::post('login', 'Resturant\AuthController@login');
        Route::post('reset-password', 'Resturant\AuthController@reset');
        Route::post('new-password', 'Resturant\AuthController@password');

        Route::group(['middleware'=>'auth:resturant'],function(){
            Route::post('profile', 'Resturant\AuthController@profile');
           // Route::post('change-password', 'Restaurant\AuthController@changePassword');
            Route::post('signup-token', 'Resturant\AuthController@registerToken');
           // Route::post('remove-token', 'Restaurant\AuthController@removeToken');

            Route::get('my-orders','Resturant\MainController@myOrders');
            Route::get('show-order','Resturant\MainController@showOrder');
            //?????
            Route::post('confirm-order','Resturant\MainController@confirmOrder');
            Route::post('accept-order','Resturant\MainController@acceptOrder');
            Route::post('reject-order','Resturant\MainController@rejectOrder');

            Route::get('my-offers','Resturant\MainController@myOffers');
            Route::post('new-offer','Resturant\MainController@newOffer');
            Route::post('update-offer','Resturant\MainController@updateOffer');
            Route::post('delete-offer','Resturant\MainController@deleteOffer');

            Route::get('my-products','Resturant\MainController@myProducts');
            Route::post('new-product','Resturant\MainController@newProduct');
            Route::post('update-product','Resturant\MainController@updateProduct');
            Route::post('delete-product','Resturant\MainController@deleteProduct');

            Route::get('my-categories','Resturant\MainController@myCategories');
            Route::post('new-category','Resturant\MainController@newCategory');
            Route::post('update-category','Resturant\MainController@updateCategory');
            Route::post('delete-category','Resturant\MainController@deleteCategory');

            Route::get('notifications','Resturant\MainController@notifications');






        });
    });




    Route::group(['prefix' =>'client'],function(){
        Route::post('sign-up', 'Client\AuthController@register');
        Route::post('login', 'Client\AuthController@login');
        Route::post('reset-password', 'Client\AuthController@resetpassword');
        Route::post('new-password', 'Client\AuthController@newpassword');

        Route::group(['middleware'=>'auth:client'],function(){
            Route::post('profile', 'Client\AuthController@profile');

            Route::post('signup-token', 'Client\AuthController@registerToken');

//
            Route::post('new-order','Client\MainController@newOrder');
            Route::get('my-orders','Client\MainController@myOrders');
            Route::get('show-order','Client\MainController@showOrder');

           // Route::get('latest-order','Client\MainController@latestOrder');
           // Route::post('confirm-order','Client\MainController@confirmOrder');
           // Route::post('decline-order','Client\MainController@declineOrder');

           // Route::post('restaurant/review','Client\MainController@review');
            Route::get('notifications','Client\MainController@notifications');
        });
    });

});
