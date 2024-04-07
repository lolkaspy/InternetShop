<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class ProfileController extends Controller
{
    public function __invoke(): Renderable
    {
        return view('profile');
    }
}
