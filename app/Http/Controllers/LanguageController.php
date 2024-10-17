<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        Log::info("Switching language. Requested: " . $lang);

        if (in_array($lang, ['en', 'fr'])) {
            Session::put('applocale', $lang);
            App::setLocale($lang);
            Session::save();  // Ensure the session is saved

            Log::info("Language switched. New App Locale: " . App::getLocale());
            Log::info("Language switched. New Session Locale: " . Session::get('applocale'));
        } else {
            Log::warning("Invalid language requested: " . $lang);
        }

        return redirect()->back();
    }
}