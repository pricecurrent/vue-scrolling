<?php

namespace App\Http\Controllers;

use App\Cat;
use Illuminate\Http\Request;

class CatCommentsController extends Controller
{
    public function store(Request $request, Cat $cat)
    {
        $cat->comments()->create([
            'body' => $request->body,
        ]);
    }
}
