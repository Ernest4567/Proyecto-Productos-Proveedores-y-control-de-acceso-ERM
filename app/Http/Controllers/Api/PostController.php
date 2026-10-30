<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()
            ->posts()
            ->latest()
            ->paginate(15);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        return PostResource::make($post)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Post $post)
    {
        abort_if($post->user_id !== $request->user()->id, 403);

        return PostResource::make($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        abort_if($post->user_id !== $request->user()->id, 403);

        $post->update($request->validated());

        return PostResource::make($post);
    }

    public function destroy(Request $request, Post $post)
    {
        abort_if($post->user_id !== $request->user()->id, 403);

        $post->delete();

        return response()->noContent();
    }
}
