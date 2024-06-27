<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function set(string $locale, Request $request)
    {
        $request->session()->put("locale", $locale);

        return redirect()->back();
    }
}
