<?php

namespace App\Http\Controllers;

use App\Cat;
use Illuminate\Http\Request;

class CatCommentsController extends Controller
{
    public function index(Cat $cat)
    {
        $comments = $cat->comments()->parent()->with('replies')->get();

        return response()->json($comments);
    }

    public function store(Request $request, Cat $cat)
    {
        $comment = $cat->comments()->create([
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return response()->json($comment);
    }
}
