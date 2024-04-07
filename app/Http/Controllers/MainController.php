<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __invoke(): Renderable
    {
        return view('main');
    }
}
