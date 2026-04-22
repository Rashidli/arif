<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Image;
use App\Models\Setting;
use App\Models\Social;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share data with all front views
        View::composer('front.*', function ($view) {
            // Categories for navigation (only selected ones)
            $categories = BlogCategory::active()->showOnHome()->get();

            // Social links
            $socials = Social::where('is_active', true)->orderBy('order')->get();

            // Logo & Favicon
            $logo = Image::where('key', 'logo')->first();
            $favicon = Image::where('key', 'favicon')->first();

            // Settings
            $settings = Setting::pluck('value', 'key')->toArray();

            $view->with(compact('categories', 'socials', 'logo', 'favicon', 'settings'));
        });
    }
}
