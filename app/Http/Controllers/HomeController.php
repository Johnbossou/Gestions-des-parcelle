<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return Auth::check()
            ? Redirect::route('dashboard')
            : Redirect::route('login');
    }
}