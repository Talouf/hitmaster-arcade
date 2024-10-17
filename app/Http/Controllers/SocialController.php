<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function facebook()
    {
        // Redirect to HitMaster Arcade's Facebook page
        return redirect('https://www.facebook.com/HitMasterArcade');
    }

    public function twitter()
    {
        // Redirect to HitMaster Arcade's Twitter page
        return redirect('https://www.twitter.com/HitMasterArcade');
    }

    public function instagram()
    {
        // Redirect to HitMaster Arcade's Instagram page
        return redirect('https://www.instagram.com/HitMasterArcade');
    }
}