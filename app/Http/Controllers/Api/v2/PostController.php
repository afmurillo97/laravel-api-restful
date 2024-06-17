<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\PostCollection;
use App\Http\Requests\PostFormRequest;
use App\Http\Resources\V2\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): PostCollection
    {
        return new PostCollection(Post::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request): JsonResponse
    {
        try {
            $post = new Post();
            $post->user_id = 1;
            $post->title = $request->input('title');
            $post->slug = $request->input('slug');
            $post->content = $request->input('content');
            $post->save();

            return $this->successResponse('Post created successfully', $post->id, 201);
        } catch (\Exception $e) {
            Log::error('Error creating resource ' . $e->getMessage() . ' In Line: ' . $e->getLine());
            return $this->errorResponse('Failed to create post', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return $this->successResponse('Post retrieved successfully', new PostResource($post), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, Post $post): JsonResponse
    {
        try {
            $post->title = $request->input('title');
            $post->slug = $request->input('slug');
            $post->content = $request->input('content');
            $post->save();

            return $this->successResponse('Post updated successfully', $post->id, 200);
        } catch (\Exception $e) {
            Log::error('Error updating resource ' . $e->getMessage() . ' In Line: ' . $e->getLine());
            return $this->errorResponse('Failed to update post', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $post->delete();

            return $this->successResponse('Post deleted successfully', null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting resource ' . $e->getMessage() . ' In Line: ' . $e->getLine());
            return $this->errorResponse('Failed to delete post', 500);
        }
    }

    /**
     * Helper method to return a success response.
     */
    private function successResponse(string $message, $data = null, int $status): JsonResponse
    {
        $response = ['message' => $message];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $status);
    }

    /**
     * Helper method to return an error response.
     */
    private function errorResponse(string $message, int $status): JsonResponse
    {
        return response()->json(['error' => $message], $status);
    }
}
