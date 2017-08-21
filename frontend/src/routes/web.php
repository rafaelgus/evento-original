<?php

Auth::routes();

Route::get('/', 'Frontend\ArticleController@getHome');
Route::get('/articulo/detalle/{slug}','Frontend\ArticleController@articleDetail');

Route::get('/' . trans('frontend/shopping_cart.slug'), 'Frontend\CartController@show');
Route::post('/addToCart', 'Frontend\CartController@addToCart');
Route::get('/removeToCart/{rowId}', 'Frontend\CartController@removeToCart');
Route::get('/destroyCart', 'Frontend\CartController@destroyCart');
Route::get('/cartItems', 'Frontend\CartController@getItemQuantity');

Route::get('/' . trans('frontend/my_wishlist.slug'), function () {
    return view('frontend.my_wishlist');
});

Route::get('/' . trans('sections.contact'), function () {
    return view('frontend.contact_us');
});

Route::get('/' . trans('frontend/about_us.slug'), function () {
    return view('frontend.about_us');
});

Route::get('/' . trans('frontend/terms_and_conditions.slug'), function () {
    return view('frontend.terms_and_conditions');
});

Route::get('/articles/storage/{filename}', 'Frontend\ArticleController@getImage');

Route::get('/mi-cuenta', function () {
    return view('frontend.profile.my_account');
})->middleware('auth');


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
        Route::group(['prefix' => '/color'], function () {
            Route::get('/create', 'Backend\ColorController@create');
            Route::post('/', 'Backend\ColorController@store');
            Route::get('/', 'Backend\ColorController@index');
            Route::get('/{id}/edit', 'Backend\ColorController@edit');
            Route::put('/{id}', 'Backend\ColorController@update');
            Route::get('/getDatatable', 'Backend\ColorController@getDatatable');
            Route::get('/getAll', 'Backend\ColorController@getAllColors');
        });
        Route::group(['prefix' => '/flavour'], function () {
            Route::get('/create', 'Backend\FlavourController@create');
            Route::post('/', 'Backend\FlavourController@store');
            Route::get('/', 'Backend\FlavourController@index');
            Route::get('/{id}/edit', 'Backend\FlavourController@edit');
            Route::put('/{id}', 'Backend\FlavourController@update');
            Route::get('/getDatatable', 'Backend\FlavourController@getDatatable');
            Route::get('/getAll', 'Backend\FlavourController@getAllFlavours');
        });
        Route::group(['prefix' => '/healthy'], function () {
            Route::get('/create', 'Backend\HealthyController@create');
            Route::post('/', 'Backend\HealthyController@store');
            Route::get('/', 'Backend\HealthyController@index');
            Route::get('/{id}/edit', 'Backend\HealthyController@edit');
            Route::put('/{id}', 'Backend\HealthyController@update');
            Route::get('/getDatatable', 'Backend\HealthyController@getDatatable');
            Route::get('/getAll', 'Backend\HealthyController@getAllHealthy');
        });
        Route::group(['prefix' => '/brand'], function () {
            Route::get('/create', 'Backend\BrandController@create');
            Route::post('/', 'Backend\BrandController@store');
            Route::get('/', 'Backend\BrandController@index');
            Route::get('/{id}/edit', 'Backend\BrandController@edit');
            Route::put('/{id}', 'Backend\BrandController@update');
            Route::get('/getDatatable', 'Backend\BrandController@getDatatable');
            Route::get('/getAll', 'Backend\BrandController@getAllBrands');
        });
        Route::group(['prefix' => '/allergen'], function () {
            Route::get('/create', 'Backend\AllergenController@create');
            Route::get('/{id}/edit', 'Backend\AllergenController@edit');
            Route::get('/', 'Backend\AllergenController@index');
            Route::post('/', 'Backend\AllergenController@store');
            Route::put('/{id}', 'Backend\AllergenController@update');
            Route::get('getAllergens', 'Backend\AllergenController@getDataTables');
            Route::get('/getAll', 'Backend\AllergenController@getAllAllergens');
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
            Route::get('/getAll', 'Backend\CategoryController@getAllCategories');
        });
        Route::group(['prefix' => '/tags'], function () {
            Route::get('/create', 'Backend\TagController@create');
            Route::get('/{id}/edit', 'Backend\TagController@edit');
            Route::get('/', 'Backend\TagController@index');
            Route::post('/', 'Backend\TagController@store');
            Route::put('/{id}', 'Backend\TagController@update');
            Route::get('getTags', 'Backend\TagController@getDataTables');
            Route::get('/getAll', 'Backend\TagController@getAllTags');
        });
        Route::group(['prefix' => '/articles'], function () {
            Route::get('/create', 'Backend\ArticleController@create');
            Route::get('/{id}/edit', 'Backend\ArticleController@edit');
            Route::get('/', 'Backend\ArticleController@index');
            Route::get('/getArticles', 'Backend\ArticleController@getDataTables');
            Route::post('/', 'Backend\ArticleController@store');
            Route::put('/{id}', 'Backend\ArticleController@update');
            Route::post('/uploadImage', 'Backend\ArticleController@uploadImages');
            Route::post('/uploads/delete/{imageId}', 'Backend\ArticleController@deleteImage');
            Route::get('/storage/{filename}', 'Backend\ArticleController@getImage');
            Route::get('/prices/{articleId}', 'Backend\ArticleController@getPrices');
            Route::post('/prices/update', 'Backend\ArticleController@updatePrice');
        });
        Route::group(['prefix' => '/ingredients'], function () {
            Route::get('/create', 'Backend\IngredientController@create');
            Route::get('/{id}/edit', 'Backend\IngredientController@edit');
            Route::get('/', 'Backend\IngredientController@index');
            Route::get('/getIngredients', 'Backend\IngredientController@getDataTables');
            Route::put('/{id}', 'Backend\IngredientController@update');
            Route::post('/', 'Backend\IngredientController@store');
            Route::get('/getAll', 'Backend\IngredientController@getAll');
        });
        Route::group(['prefix' => '/licenses'], function () {
            Route::get('/create', 'Backend\LicenseController@create');
            Route::get('/{id}/edit', 'Backend\LicenseController@edit');
            Route::get('/getLicenses', 'Backend\LicenseController@getDataTables');
            Route::get('/', 'Backend\LicenseController@index');
            Route::put('/{id}', 'Backend\LicenseController@update');
            Route::post('/', 'Backend\LicenseController@store');
            Route::get('/getAll', 'Backend\LicenseController@getAll');
        });
        Route::group(['prefix' => '/users'], function () {
            Route::get('/create', 'Backend\UserController@create');
            Route::get('/{id}/edit', 'Backend\UserController@edit');
            Route::get('/', 'Backend\UserController@index');
            Route::get('/getUsers', 'Backend\UserController@getDataTables');
            Route::post('/', 'Backend\UserController@store');
            Route::put('/{id}', 'Backend\UserController@update');
            Route::get('/roles', 'Backend\UserController@getRoles');
            Route::get('/editPassword/{id}', 'Backend\UserController@editPassword');
            Route::put('/updatePassword/{id}', 'Backend\UserController@updatePassword');
        });
    });
});

Route::get('/{categorySlug?}', 'Frontend\ArticleController@index');
Route::get('/articles/{categorySlug?}', 'Frontend\ArticleController@getFilteredArticles');

Route::get('/home', 'HomeController@index')->name('home');
