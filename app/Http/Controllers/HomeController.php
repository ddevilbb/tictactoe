<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        print_r(123);
        print_r($request->user());
    }
}