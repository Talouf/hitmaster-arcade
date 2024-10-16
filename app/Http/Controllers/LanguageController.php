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
        if (in_array($lang, ['en', 'fr'])) {
            Session::put('applocale', $lang);
            App::setLocale($lang);
            Log::info("Language switched to: " . $lang);
        }
        return redirect(url()->previous())->withInput();
    }
}