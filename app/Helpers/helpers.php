<?php

use App\Models\Word;
use Illuminate\Support\Facades\Cache;

if (!function_exists('word')) {
    function word(string $key, ?string $default = null): string
    {
        $locale = app()->getLocale();

        // Find word by key
        $word = Word::where('key', $key)->first();

        if ($word) {
            // Get translation for current locale
            $translation = $word->translate($locale);
            if ($translation && $translation->title) {
                return $translation->title;
            }
        }

        // Auto-create word if it doesn't exist (for development)
        if (!$word && $default) {
            try {
                $word = Word::create(['key' => $key]);
                foreach (['az', 'en', 'ru'] as $lang) {
                    $word->translateOrNew($lang)->title = $default;
                }
                $word->save();
            } catch (\Exception $e) {
                // Ignore if word creation fails
            }
        }

        return $default ?? $key;
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}
