<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // 200 OK + latest works if timestamps are enabled
        return response()->json(Post::latest()->get(), 200);
    }

    public function store(Request $request)
    {
        // if 422 validation error, it will auto return with errors
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        $post = Post::create($data);

        // 201 Created
        return response()->json($post, 201);
    }


}
