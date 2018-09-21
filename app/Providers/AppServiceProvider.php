<?php

namespace App\Providers;

use App\User;
use App\Product;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * retry will run the function declared withing
     * IF that action fails it will attemp to re-run it after a set time has passed
     * retry takes 3 parameteres
     * - Number of time to retry
     * - Function with the code to run
     * - Delay between attemptes in miliseconds
     * if it still fails, it will throw an exception
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Declare something to happen when updating product
        Product::updated(function($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE_PRODUCT;

                $product->save();
            }
        });

        /*
        User::created(function($user) {
            retry(5, function() use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));
            }, 100);
        });
        */

        /*
        User::updated(function($user) {
            if ($user->isDirty('email')) {
                retry(5, function() use ($user) {
                    Mail::to($user->email)->send(new UserMailChanged($user));
                }, 100);
            }
        });
        */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
