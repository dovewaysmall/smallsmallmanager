<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\RoleHelper;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with([
                'canDelete' => RoleHelper::canDelete(),
                'isCTO' => RoleHelper::isCTO(),
                'isCX' => RoleHelper::isCX()
            ]);
        });
    }

    public function register()
    {
        //
    }
}