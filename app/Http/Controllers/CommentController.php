<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $request->validate([
            'isikomentar' => 'required',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'isikomentar' => $request->input('isikomentar'),
        ]);

        return back();
    }
}

