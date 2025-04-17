<?php

namespace Hansoft\CloudSass\Http\Controllers;

use Illuminate\Routing\Controller;

class ClientsController extends Controller
{
    public function index()
    {
        return view('cloud-sass::index');
    }
}
