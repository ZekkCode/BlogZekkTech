<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class StringMacroServiceProvider extends ServiceProvider
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
        Str::macro('readingTime', function ($text) {
            $words = str_word_count(strip_tags($text));
            $minutes = ceil($words / 200);
            return $minutes;
        });
    }
}
