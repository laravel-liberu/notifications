<?php

namespace LaravelLiberu\Notifications\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Routing\Controller;

class Destroy extends Controller
{
    public function __invoke(DatabaseNotification $notification)
    {
        $notification->delete();
    }
}
