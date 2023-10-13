<?php

namespace LaravelLiberu\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DestroyAll extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->notifications()->delete();
    }
}
