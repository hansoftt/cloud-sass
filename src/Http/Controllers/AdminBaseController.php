<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminBaseController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->headers->get('customer-code') !== null) {
            return abort(403, 'Access denied. This route is not available for clients.');
        }
    }
}
