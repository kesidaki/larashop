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

/*
Buyers Routes: 
~api/buyers
*/
Route::resource('buyers', 'Api\Buyer\BuyerController', ['only' => ['index','show']]);

/*
Buyers Transaction Routes: 
~api/buyers/{id}/transactions
*/
Route::resource('buyers.transactions', 'Api\Buyer\BuyerTransactionController', ['only' => ['index']]);

/*
Buyers Products Routes: 
~api/buyers/{id}/products
*/
Route::resource('buyers.products', 'Api\Buyer\BuyerProductController', ['only' => ['index']]);

/*
Buyers Sellers Routes: 
~api/buyers/{id}/sellers
*/
Route::resource('buyers.sellers', 'Api\Buyer\BuyerSellerController', ['only' => ['index']]
);

/*
Buyers Categories Routes: 
~api/buyers/{id}/categories
*/
Route::resource('buyers.categories', 'Api\Buyer\BuyerCategoryController', ['only' => ['index']]);

/*
Categories Routes: 
~api/categories
*/
Route::resource('categories', 'Api\Category\CategoryController', ['except' => [	'create','edit']]);

/*
Categories Products Routes: 
~api/categories/{id}/products
*/
Route::resource('categories.products', 'Api\Category\CategoryProductController', ['only' => ['index']]);

/*
Categories Sellers Routes: 
~api/categories/{id}/sellers
*/
Route::resource('categories.sellers', 'Api\Category\CategorySellerController', ['only' => ['index']]);

/*
Categories Transactions Routes: 
~api/categories/{id}/transactions
*/
Route::resource('categories.transactions', 'Api\Category\CategoryTransactionController', ['only' => ['index']]);

/*
Categories Buyers Routes: 
~api/categories/{id}/buyers
*/
Route::resource('categories.buyers', 'Api\Category\CategoryBuyerController', ['only' => ['index']]);

/*
Products Routes: 
~api/products
*/
Route::resource('products', 'Api\Product\ProductController', ['only' => ['index','show']]);

/*
Products Transactions Routes: 
~api/products/{id}/transactions
*/
Route::resource('products.transactions', 'Api\Product\ProductTransactionController', ['only' => ['index']]);

/*
Products Buyers Routes: 
~api/products/{id}/buyers
*/
Route::resource('products.buyers', 'Api\Product\ProductBuyerController', ['only' => ['index','store']]);

/*
Products Categories Routes: 
~api/products/{id}/categories
*/
Route::resource('products.categories', 'Api\Product\ProductCategoryController', ['only' => ['index','update','destroy']]);

/*
Products Categories Routes: 
~api/products/{id}/prices
*/
Route::resource('products.prices', 'Api\Product\ProductPriceController', ['only' => ['index','update','destroy']]);

/*
Products Categories Routes: 
~api/products/{product->id}/buyers/{buyer->id}/transactions
*/
Route::resource('products.buyers.transactions', 'Api\Product\ProductBuyerTransactionController', ['only' => ['store']]);

/*
Sellers Routes: 
~api/sellers
*/
Route::resource('sellers', 'Api\Seller\SellerController', ['only' => ['index','show']]);

/*
Sellers Buyer Routes: 
~api/sellers/{id}/buyers
*/
Route::resource('sellers.buyers', 'Api\Seller\SellerBuyerController', ['only' => ['index']]);

/*
Sellers Categories Routes: 
~api/sellers/{id}/categories
*/
Route::resource('sellers.categories', 'Api\Seller\SellerCategoryController', ['only' => ['index']]);

/*
Sellers Transactions Routes: 
~api/sellers/{id}/transactions
*/
Route::resource('sellers.transactions', 'Api\Seller\SellerTransactionController', ['only' => ['index']]);

/*
Sellers Products Routes: 
~api/sellers/{id}/products
*/
Route::resource('sellers.products', 'Api\Seller\SellerProductController', ['only' => ['index','store','update','destroy']]);

/*
Transactions Routes: 
~api/transactions
*/
Route::resource('transactions', 'Api\Transaction\TransactionController', ['only' => ['index','show']]);

/*
Transactions Categories Routes: 
~api/transactions/{id}/categories
*/
Route::resource('transactions.categories', 'Api\Transaction\TransactionCategoryController', ['only' => ['index']]);

/*
Transactions Sellers Routes: 
~api/tsansactions/{id}/sellers
*/
Route::resource('transactions.sellers', 'Api\Transaction\TransactionSellerController', ['only' => ['index']]);

/*
Users Routes: 
~api/users
*/
Route::resource('users', 'Api\User\UserController', ['except' => ['create','edit']]);

/*
Users Verify Routes: 
~api/users/verify/{token}
*/
//Route::name('verify')->get('users/verify/{token}', 'Api\User\UserController@verify');

/*
Users Resend Verify Routes: 
~api/users/{user}/resend
*/
Route::name('resend')->get('users/{user}/resend', 'Api\User\UserController@resend');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');