<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localize extends Component
{
    public $currentLocale;

    public function __construct()
    {
        $locale = Session::get('applocale', config('app.locale'));
        App::setLocale($locale);
        $this->currentLocale = $locale;
    }

    public function render()
    {
        return view('components.localize');
    }
}