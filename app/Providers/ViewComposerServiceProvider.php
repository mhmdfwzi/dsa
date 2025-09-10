<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // مشاركة بيانات التصنيفات مع جميع الـ views
        View::composer('*', function ($view) {
            $categories = Category::withCount('courses')->get();
            $view->with('categories', $categories);
        });
    }
}