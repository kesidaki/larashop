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

/*Base Website Routes*/
Route::get('/',                                 'Website\HomeController@index');
Route::get('/sxetika-me-emas',                  'Website\HomeController@about');
Route::get('/epikoinonia',                      'Website\HomeController@epikoinonia');
Route::get('/oroi-xrisis',                      'Website\HomeController@oroiXrisis');
Route::get('/products/{cat1?}/{cat2?}/{cat3?}', 'Website\ProductsController@index');
Route::get('/product/{slug}',                   'Website\ProductsController@product');
Route::get('/search/{term}',                    'Website\ProductsController@search');

/*Authentication Routes*/
Auth::routes();
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

/*Cart Routes*/
Route::get('/cart',     'Website\CartController@index');
Route::get('/cart/inc', 'Website\CartController@increase');
Route::get('/cart/dec', 'Website\CartController@decrease');
Route::get('/cart/dlt', 'Website\CartController@delete');
Route::post('/cart',    'Website\CartController@add');

/*Checkout Routes*/
Route::get('/checkout',              'Website\CheckoutController@index');
Route::post('/checkout',             'Website\CheckoutController@complete');
Route::get('/checkout/details/{id}', 'Website\CheckoutController@details');

/*Account Routes*/
Route::get('/account',                    'Website\AccountController@index');
Route::get('/account/stoixeia-paradosis', 'Website\AccountController@information');
Route::get('/account/paraggelies',        'Website\AccountController@orders');
Route::get('/account/paraggelia/{id}',    'Website\AccountController@order');
Route::get('/account/allagi-kodikou',     'Website\AccountController@changePassword');

/*Administraton Panel Routes*/
Route::get('/admin/home',                          'Website\Admin\HomeController@index');
Route::get('/admin/products/{category?}',          'Website\Admin\ProductsController@products');
Route::get('/admin/product/{id}',                  'Website\Admin\ProductsController@product');
Route::get('/admin/categories',                    'Website\Admin\CategoriesController@categories');
Route::get('/admin/category/{id}',                 'Website\Admin\CategoriesController@category');
Route::get('/admin/brands',                        'Website\Admin\BrandsController@brands');
Route::get('/admin/orders',                        'Website\Admin\OrdersController@orders');
Route::get('/admin/order/{id}',                    'Website\Admin\OrdersController@order');
Route::get('/admin/create-parastatiko/{id}/{type}','Website\Admin\OrdersController@createParastatiko');
Route::get('/parastatiko/{id}',                    'Website\Admin\OrdersController@parastatiko');
Route::post('/admin/create/product',               'Website\Admin\ProductsController@createProduct');
Route::post('/admin/create/category',              'Website\Admin\CategoriesController@createCategory');
Route::post('/admin/create/subcategory',           'Website\Admin\CategoriesController@createSubcategory');
Route::post('/admin/create/brand',                 'Website\Admin\BrandsController@createBrand');
Route::post('/admin/update/product/info',          'Website\Admin\ProductsController@updateProductInfo');
Route::post('/admin/update/product/prices',        'Website\Admin\ProductsController@updateProductPrices');
Route::post('/admin/update/product/categories',    'Website\Admin\ProductsController@updateProductCategories');
Route::post('/admin/update/product/subcategories', 'Website\Admin\ProductsController@updateProductSubcategories');
Route::post('/admin/update/category',              'Website\Admin\CategoriesController@updateCategory');
Route::post('/admin/update/subcategory',           'Website\Admin\CategoriesController@updateSubcategory');
Route::post('/admin/update/brand',                 'Website\Admin\BrandsController@updateBrand');
Route::post('/admin/order/update',                 'Website\Admin\OrdersController@updateOrder');
Route::post('/cancelParastatiko',                  'Website\Admin\OrdersController@cancelParastatiko');

/*Ajax Requests*/
Route::get('/request/products',                'Website\RequestsController@products');
Route::get('/request/statistics/visits',       'Website\RequestsController@visits');
Route::get('/request/statistics/product/{id}', 'Website\RequestsController@product');