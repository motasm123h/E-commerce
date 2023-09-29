<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function index(){
        $translations = [];
        $locales = config('app.locales');
        foreach ($locales as $locale) {
            $translationFile = resource_path('lang/' . $locale . '/api.php');
            if (file_exists($translationFile)) {
                $translations[$locale] = require $translationFile;
            }
        }

        return response()->json(['translations' => $translations]);
    }
}
