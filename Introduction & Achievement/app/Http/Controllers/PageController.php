<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function site()
    {
        return view('site');
    }

    public function introduction()
    {
        return view('introduction');
    }

    public function achievement()
    {
        return view('achievement');
    }
}
