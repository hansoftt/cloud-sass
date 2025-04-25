<?php
namespace Hansoft\CloudSass\Http\Controllers;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        return view('cloud-sass::dashboard');
    }
}
