<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        try {
            //code...

            $user = User::where('email', 'admin@gmail.com')->first();
            if (!$user) {
                User::create([
                    'id' => Str::uuid(),
                    'first_name' => 'Admin',
                    'last_name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('123')
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
