<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('cloud-sass::dashboard');
    }
}
