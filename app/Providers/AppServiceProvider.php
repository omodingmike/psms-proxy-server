<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
//        Artisan::call('migrate:fresh');
//        Patient::create([
//            'email' => 'patient@gmail.com',
//            'name' => 'omoding mike',
//            'phone' => '0704034249',
//            'location' => 'Salama',
//            'age' => 30,
//        ]);

//        User::create([
//            'name' => 'omoding mike',
//            'email' => 'omodingmike@gmail.com',
//            'is_admin' => 1,
//            'password' => Hash::make('password'),
//        ]);


//        Patient::create([
//            'name' => 'omoding mike',
//            'phone' => '0704034249',
//            'age' => 30,
//            'location' => 'salama',
//            'email' => 'omodingmike@gmail.com',
//        ]);

        Artisan::call('route:clear');
    }
}
