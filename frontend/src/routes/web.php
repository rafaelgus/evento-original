<?php


Config::set('eventoriginal.designs.mugs.article_id', 1);

Auth::routes();
Route::post('register-customer', 'Frontend\CustomerController@register')->name('register_customer');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'Frontend\ArticleController@getHome');
Route::get('/search/{search}', 'Frontend\ArticleController@search');
Route::post('/articles/search', 'Frontend\ArticleController@getSearch');

Route::get(
    '/' . trans('routes.article') . '/' . trans('routes.detail') . '/{identifier}',
    'Frontend\ArticleController@articleDetail'
)->name('article.detail');

Route::get('/' . trans('frontend/shopping_cart.slug'), 'Frontend\CartController@show');
Route::post('/addToCart', 'Frontend\CartController@addToCart');
Route::get('/removeToCart/{rowId}', 'Frontend\CartController@removeToCart');
Route::get('/destroyCart', 'Frontend\CartController@destroyCart');
Route::get('/cartItems', 'Frontend\CartController@getItemQuantity');
Route::post('/updateQty', 'Frontend\CartController@updateQuantity');
Route::post('/updateVariantDetail', 'Frontend\CartController@updateVariantDetail');

Route::get('/crear-diseño-desde-cero', 'Frontend\DesignController@createDesign');
Route::get('/crear-papel-comestible-desde-cero', 'Frontend\DesignController@createEdiblePaper');
Route::get('/diseñar-papel-comestible-desde-cero/{id}', 'Frontend\DesignController@designEdiblePaper');
Route::get('/diseñar-taza-desde-cero', 'Frontend\DesignController@designMug')->name('design_mug');
Route::post('/buy-design', 'Frontend\CartController@buyDesign')->name('buy_design');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/checkout/billing', 'Frontend\PaymentController@billingInformation');
    Route::post('/checkout/shipping', 'Frontend\PaymentController@shippingInformation');
    Route::post('/checkout/order', 'Frontend\PaymentController@checkout');
    Route::post('/checkout/addVoucher', 'Frontend\PaymentController@addVoucherInCheckout');
    Route::post('/payment/{id}', 'Frontend\PaymentController@process');
    Route::get('/paypalConfirm', 'Frontend\PaymentController@getPaypalConfirm');
    Route::get('/paypalCancel', 'Frontend\PaymentController@getPaypalCancel');
});

Route::post('/discount', 'Frontend\VoucherController@useVoucher');

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
})->name('terms_and_conditions');

/**
 * Designer routes
 */
Route::get('/' . trans('designer.register.slug'), 'Frontend\DesignerController@register')->name('designer.getRegister');
Route::post(
    '/' . trans('designer.register.slug'),
    'Frontend\DesignerController@postRegister'
)->name('designer.postRegister');

Route::get('/articles/storage/{filename}', 'Frontend\ArticleController@getImage');

Route::post('/paypal-payouts-webhook', 'Backend\PaypalController@payoutWebhook');

Route::middleware(['auth'])->group(function () {
    Route::get('/' . trans('frontend/my_account.slug'), function () {
        return view('frontend.profile.my_account');
    })->name('my_account');

    Route::get(
        '/' . trans('frontend/affiliates.title'),
        'Frontend\CustomerController@affiliateSummary'
    )->name('affiliates.summary');

    Route::get('/editor-edible-paper-a4', 'Frontend\DesignerController@showEditor');

    /**
     * Designer routes
     */
    Route::group(['middleware' => ['auth', 'designer']], function () {
        Route::post('/save-design', 'Frontend\DesignerController@storeDesign')->name('save_design');
        Route::post('/finalize-design', 'Frontend\DesignerController@finalizeDesign')->name('finalize_design');
        Route::get(
            '/' . trans('designer.edit_design.slug') . '/{id}',
            'Frontend\DesignerController@editDesign'
        )->name('edit_design');
        Route::get(
            '/' . trans('designer.show_rejected.slug') . '/{id}',
            'Frontend\DesignerController@showRejected'
        )->name('show_rejected');
        Route::get(
            '/' . trans('designer.my_designs.slug'),
            'Frontend\DesignerController@showDesigns'
        )->name('designer.myDesigns');
        Route::get(
            '/' . trans('designer.my_designs_in_review.slug'),
            'Frontend\DesignerController@showDesignsInReview'
        )->name('designer.myDesignsInReview');
        Route::get(
            '/' . trans('designer.my_designs_rejected.slug'),
            'Frontend\DesignerController@showDesignsRejected'
        )->name('designer.myDesignsRejected');
        Route::get(
            '/' . trans('designer.my_designs_published.slug'),
            'Frontend\DesignerController@showDesignsPublished'
        )->name('designer.myDesignsPublished');
        Route::get(
            '/' . trans('designer.create.slug'),
            'Frontend\DesignerController@create'
        )->name('designer.create');
        Route::get(
            '/' . trans('designer.create_edible_paper.slug'),
            'Frontend\DesignerController@createEdiblePaper'
        )->name('designer.createEdiblePaper');
        Route::get(
            '/' . trans('designer.select_edible_paper.slug') . '/{id}',
            'Frontend\DesignerController@selectEdiblePaper'
        )->name('designer.selectEdiblePaper');
        Route::get(
            '/' . trans('designer.design_edible_paper.slug') . '/{id}',
            'Frontend\DesignerController@designEdiblePaper'
        )->name('designer.designEdiblePaper');
        Route::get(
            '/' . trans('designer.send_to_review.slug') . '/{id}',
            'Frontend\DesignerController@sendToReviewView'
        )->name('designer.sendToReview');
        Route::post(
            '/send-design-to-review/{id}',
            'Frontend\DesignerController@sendDesignToReview'
        )->name('designer.sendDesignToReview');
        Route::get(
            '/download-template/{id}',
            'Frontend\DesignerController@downloadTemplate'
        )->name('designer.downloadTemplate');

        Route::get(
            '/' . trans('designer.design_mug.slug'),
            'Frontend\DesignerController@designMug'
        )->name('designer.designMug');
    });

    Route::get('/mi-cuenta', 'Frontend\AccountController@getAccount')->name('my_account');
    Route::get('/{id}/detalle', 'Frontend\AccountController@getDetails');

    Route::get(
        '/' . trans('frontend/payouts.slug'),
        'Frontend\PayoutController@getAllPaginated'
    )->name('profile.payouts');

    Route::get(
        '/' . trans('movements.slug'),
        'Frontend\MovementController@getAllPaginated'
    )->name('profile.movements');

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
            Route::group(['prefix' => '/healthy'], function () {
                Route::get('/create', 'Backend\HealthyController@create');
                Route::get('/{id}/edit', 'Backend\HealthyController@edit');
                Route::get('/getLicenses', 'Backend\HealthyController@getDataTables');
                Route::get('/', 'Backend\HealthyController@index');
                Route::put('/{id}', 'Backend\HealthyController@update');
                Route::post('/', 'Backend\HealthyController@store');
                Route::get('/getAll', 'Backend\HealthyController@getAll');
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
            Route::group(['prefix' => '/vouchers'], function () {
                Route::get('/create', 'Backend\VoucherController@create');
                Route::get('/{id}/edit', 'Backend\VoucherController@edit');
                Route::get('/', 'Backend\VoucherController@index');
                Route::post('/', 'Backend\VoucherController@store');
                Route::put('/{id}', 'Backend\VoucherController@update');
                Route::get('/getVouchers', 'Backend\VoucherController@getVouchers');
            });
            Route::group(['prefix' => '/menus'], function () {
                Route::get('/', 'Backend\MenuController@index');
                Route::get('/{id}', 'Backend\MenuController@show');
            });
            Route::group(['prefix' => '/menu-item'], function () {
                Route::get('/create', 'Backend\MenuItemController@create');
                Route::get('/create-subitem/{id}', 'Backend\MenuItemController@createSubitem');
                Route::post('/', 'Backend\MenuItemController@store');
                Route::post('/subitem', 'Backend\MenuItemController@storeSubitem');
                Route::get('/{id}', 'Backend\MenuItemController@show');
                Route::get('/{id}/edit-subitem', 'Backend\MenuItemController@editSubitem');
                Route::put('/{id}/edit-subitem', 'Backend\MenuItemController@updateSubitem');
                Route::delete('/{id}/edit-subitem', 'Backend\MenuItemController@remove');
                Route::get('/{id}/edit', 'Backend\MenuItemController@edit');
                Route::put('/{id}', 'Backend\MenuItemController@update');
            });

            Route::group(['prefix' => '/design-material-size'], function () {
                Route::get('/create', 'Backend\DesignMaterialSizeController@create');
                Route::post('/', 'Backend\DesignMaterialSizeController@store');
                Route::get('/', 'Backend\DesignMaterialSizeController@index');
                Route::get('/{id}/edit', 'Backend\DesignMaterialSizeController@edit');
                Route::put('/{id}', 'Backend\DesignMaterialSizeController@update');
                Route::get('/{id}/remove', 'Backend\DesignMaterialSizeController@remove');
                Route::get('/getDatatable', 'Backend\DesignMaterialSizeController@getDatatable');
            });

            Route::group(['prefix' => '/circular-design-variant'], function () {
                Route::get('/create', 'Backend\CircularDesignVariantController@create');
                Route::post('/', 'Backend\CircularDesignVariantController@store');
                Route::get('/', 'Backend\CircularDesignVariantController@index');
                Route::get('/{id}/edit', 'Backend\CircularDesignVariantController@edit');
                Route::put('/{id}', 'Backend\CircularDesignVariantController@update');
                Route::get('/{id}/remove', 'Backend\CircularDesignVariantController@remove');
                Route::get('/getDatatable', 'Backend\CircularDesignVariantController@getDatatable');
            });

            Route::group(['prefix' => '/design-material-type'], function () {
                Route::get('/create', 'Backend\DesignMaterialTypeController@create');
                Route::post('/', 'Backend\DesignMaterialTypeController@store');
                Route::get('/', 'Backend\DesignMaterialTypeController@index');
                Route::get('/{id}/edit', 'Backend\DesignMaterialTypeController@edit');
                Route::put('/{id}', 'Backend\DesignMaterialTypeController@update');
                Route::get('/{id}/remove', 'Backend\DesignMaterialTypeController@remove');
                Route::get('/getDatatable', 'Backend\DesignMaterialTypeController@getDatatable');
            });

            Route::group(['prefix' => '/occasions'], function () {
                Route::get('/create', 'Backend\OccasionController@create');
                Route::post('/', 'Backend\OccasionController@store');
                Route::get('/', 'Backend\OccasionController@index');
                Route::get('/{id}/edit', 'Backend\OccasionController@edit');
                Route::put('/{id}', 'Backend\OccasionController@update');
                Route::get('/{id}/remove', 'Backend\OccasionController@remove');
            });

            Route::group(['prefix' => '/odoo'], function () {
                Route::get('/articles', 'Backend\OdooController@showNotSyncArticles');
                Route::post('/articles/sync', 'Backend\OdooController@syncArticles');
            });

            Route::group(['prefix' => '/payouts'], function () {
                Route::get('/', 'Backend\PayoutController@index')->name('admin.payouts.index');
                Route::get('/pendents', 'Backend\PayoutController@showPendents')->name('admin.payouts.pendents');
                Route::get('/{id}', 'Backend\PayoutController@show')->name('admin.payouts.show');
                Route::post('/send/{id}', 'Backend\PayoutController@send')->name('admin.payouts.send');
                Route::post('/cancel/{id}', 'Backend\PayoutController@cancel')->name('admin.payouts.cancel');
            });

            Route::group(['prefix' => '/orders'], function () {
                Route::get('/{id}', 'Backend\OrderController@show')->name('admin.orders.show');
            });

            Route::group(['prefix' => '/designs'], function () {
                Route::get('/needs-review', 'Backend\DesignController@inReview')->name('admin.designs.inReview');
                Route::get('/show/{id}', 'Backend\DesignController@show')->name('admin.designs.show');
                Route::post('/approve/{id}', 'Backend\DesignController@approve')->name('admin.designs.approve');
                Route::get('/reject/{id}', 'Backend\DesignController@rejectForm')->name('admin.designs.rejectForm');
                Route::post('/reject/{id}', 'Backend\DesignController@reject')->name('admin.designs.reject');
                Route::get('/download/{id}/{quantity}/{name}', 'Backend\DesignController@download')->name('admin.designs.download');
            });
            Route::group(['prefix' => '/orders'], function () {
                Route::get('/{id}/order', 'Backend\OrderController@show')->name('admin.orders.show');
                Route::get('/', 'Backend\OrderController@index');
                Route::get('/data/getOrders', 'Backend\OrderController@getOrders');
                Route::post('/{id}/update', 'Backend\OrderController@update');
            });

        });

    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/articles/{categorySlug?}', 'Frontend\ArticleController@getFilteredArticles');
    Route::get('/{categorySlug?}', 'Frontend\ArticleController@index');
});
