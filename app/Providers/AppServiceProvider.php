<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <-- ESSA LINHA É CRUCIAL
use Mary\View\Components\MenuItem;
use Mary\View\Components\MenuSub;
use Mary\View\Components\Menu;

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
        // Registrando os aliases dos componentes Blade
        Blade::component(MenuItem::class, 'menu-item');
        Blade::component(MenuSub::class, 'menu-sub');
        Blade::component(Menu::class, 'menu');
    }
}
