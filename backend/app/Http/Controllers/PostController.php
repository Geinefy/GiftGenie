<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // 200 OK + latest() কাজ করবে যদি timestamps থাকে
        return response()->json(Post::latest()->get(), 200);
    }

    public function store(Request $request)
    {
        // 422 হলে Laravel নিজে validation error JSON দেয়
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        $post = Post::create($data);

        // 201 Created
        return response()->json($post, 201);
    }

    
}
