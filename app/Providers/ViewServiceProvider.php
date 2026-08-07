<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
class ViewServiceProvider extends ServiceProvider
{
public function boot()
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $view->with('user_settings', user_settings(Auth::id()));
        }
    });
}
}
