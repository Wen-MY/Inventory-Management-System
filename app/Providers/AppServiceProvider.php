<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Define custom validation rule for username
        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
            // Implement your validation logic for username here
            // For example, you can use regular expressions to validate the username format
            return preg_match('/^[a-zA-Z0-9_]+$/', $value);
        });

        // Set default string length for migrations
        Schema::defaultStringLength(191);
    }
}
