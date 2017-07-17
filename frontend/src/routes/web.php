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

Route::get('/', function () {
    return view('frontend.home');
});

Route::get('/articulo/detalle', function () {
    return view('frontend.articles.show');
});

Route::get('/' . trans('frontend/shopping_cart.slug'), function () {
    return view('frontend.shopping_cart');
});

Route::get('/' . trans('frontend/my_wishlist.slug'), function () {
    return view('frontend.my_wishlist');
});

Route::get('/'. trans('sections.contact'), function () {
    return view('frontend.contact_us');
});

Route::get('/{categorySlug?}', 'Frontend\ArticleController@index');

//Route::get('/', function () {
//    return view('backend.home');
//});

Route::group(['prefix' => '/management'], function () {
    Route::get('/login', 'Auth\LoginController@showManagementLoginForm');
    Route::post('/login', 'Auth\LoginController@managementLogin');
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/password/email', 'Auth\ForgotPasswordController@showManagementLinkRequestForm');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendManagementResetLinkEmail');
    Route::get('/password/reset/{token?}', 'Auth\ResetPasswordController@showManagementResetForm');
    Route::post('/password/reset', 'Auth\ResetPasswordController@managementReset');

    Route::group(['middleware' => ['web', 'auth', 'admin']], function () {
        Route::get('/', function () {
            return view('backend.home');
        });

        Route::group(['prefix' => '/category'], function () {
            Route::get('/create', 'Backend\CategoryController@create');
            Route::post('/', 'Backend\CategoryController@store');
            Route::get('/getDatatable', 'Backend\CategoryController@getDatatable');
        });
        Route::group(['prefix' => '/color'], function () {
            Route::get('/create', 'Backend\ColorController@create');
            Route::post('/', 'Backend\ColorController@store');
            Route::get('/', 'Backend\ColorController@index');
            Route::get('/{id}/edit', 'Backend\ColorController@edit');
            Route::put('/{id}', 'Backend\ColorController@update');
            Route::get('/getDatatable', 'Backend\ColorController@getDatatable');
        });
        Route::group(['prefix' => '/flavour'], function () {
            Route::get('/create', 'Backend\FlavourController@create');
            Route::post('/', 'Backend\FlavourController@store');
            Route::get('/', 'Backend\FlavourController@index');
            Route::get('/{id}/edit', 'Backend\FlavourController@edit');
            Route::put('/{id}', 'Backend\FlavourController@update');
            Route::get('/getDatatable', 'Backend\FlavourController@getDatatable');
        });
        Route::group(['prefix' => '/brand'], function () {
            Route::get('/create', 'Backend\BrandController@create');
            Route::post('/', 'Backend\BrandController@store');
            Route::get('/', 'Backend\BrandController@index');
            Route::get('/{id}/edit', 'Backend\BrandController@edit');
            Route::put('/{id}', 'Backend\BrandController@update');
            Route::get('/getDatatable', 'Backend\BrandController@getDatatable');
        });
        Route::group(['prefix' => '/allergen'], function () {
            Route::get('/create', 'Backend\AllergenController@create');
            Route::get('/{id}/edit', 'Backend\AllergenController@edit');
            Route::get('/', 'Backend\AllergenController@index');
            Route::post('/', 'Backend\AllergenController@store');
            Route::put('/{id}', 'Backend\AllergenController@update');
            Route::get('getAllergens', 'Backend\AllergenController@getDataTables');
        });
        Route::group(['prefix' => '/category'], function () {
            Route::get('/create', 'Backend\CategoryController@create');
            Route::get('{id}/edit', 'Backend\CategoryController@edit');
            Route::get('/', 'Backend\CategoryController@index');
            Route::post('/', 'Backend\CategoryController@store');
            Route::put('/{id}', 'Backend\CategoryController@update');
            Route::get('/getCategories', 'Backend\CategoryController@getDataTables');
            Route::get('/{parentId}/createSubCategory', 'Backend\CategoryController@createSubCategory');
            Route::post('/{parentId}/storeSubCategory', 'Backend\CategoryController@storeSubCategory');
            Route::get('/{parentId}/subcategories', 'Backend\CategoryController@subcategories');
            Route::get('/{parentId}/getSubCategory', 'Backend\CategoryController@getSubCategories');
        });
    });
});
