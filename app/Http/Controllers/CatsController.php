<?php

namespace App\Http\Controllers;

use App\Cat;
use Illuminate\Http\Request;

class CatsController extends Controller
{
    public function index()
    {
        $cats = Cat::offset(request('offset'))->take(10)->get();

        return response()->json($cats);
    }
}
