<?php

namespace App\Providers;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
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
        //директивы для админа и пользователя
        Blade::directive('admin', function ($expression) {
            return "<?php if(Auth::check() && request()->user()->role->name == 'Администратор'): ?>";
        });

        Blade::directive('endadmin', function ($expression) {
            return "<?php endif; ?>";
        });

        Blade::directive('user', function ($expression) {
            return "<?php if(Auth::check() && request()->user()->role->name == 'Пользователь'): ?>";
        });

        Blade::directive('enduser', function ($expression) {
            return "<?php endif; ?>";
        });


        Paginator::useBootstrap();

    }
}
