<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *  title="Post Management API",
 *  version="1.0",
 *  description="A robust and versatile API for managing blog posts, featuring both public and private routes. This API enables users to create, read, update, and delete posts, with secure authentication and role-based access control. Ideal for demonstrating API development and RESTful principles in Laravel.",
 * )
 * 
 * @OA\Server(url="http://localhost/laravel-api-restful/public")
 * 
 * @OA\SecurityScheme(
 *  securityScheme="sanctum",
 *  type="http",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  description="Enter the token in the format: Bearer {token}"
 * )
*/
class PostController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/v1/posts",
     *  tags={"Posts"},
     *  summary="Retrieve All Blog Posts",
     *  description="Fetch a comprehensive list of all blog posts. This endpoint supports pagination and returns an array of post objects with their respective details, ensuring efficient data retrieval and display.",
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Page number for pagination",
     *      required=false,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="A paginated array of blog posts",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/PostResource")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Not Found",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Resource not found")
     *      )
     *  )
     * )
    */
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::latest()->paginate());
    }

    /**
     * @OA\Post(
     *  path="/api/v1/posts",
     *  tags={"Posts"},
     *  summary="Create a New Blog Post",
     *  description="Create a new blog post with the provided details. This endpoint requires authentication.",
     *  security={{"sanctum": {}}},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string", example="New Post Title"),
     *          @OA\Property(property="slug", type="string", example="new slug for the post"),
     *          @OA\Property(property="content", type="string", example="This is the content of the new post."),
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Post created successfully, return post_id",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="Post created successfully"
     *          ),
     *          @OA\Property(
     *              property="data",
     *              type="integer",
     *              example=1
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="error",
     *              type="string",
     *              example="Unauthorized, you must log in first"
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Unprocessable",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Validation error"),
     *          @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}}),
     *      )
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Internal server error",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Failed to create post")
     *      )
     *  )
     * )
    */
    public function store(PostFormRequest $request): JsonResponse
    {
        try {
            $post = new Post();
            $post->user_id = auth()->id();
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
     * @OA\Get(
     *  path="/api/v1/posts/{post}",
     *  tags={"Posts"},
     *  summary="Retrieve a Single Blog Post",
     *  description="Fetch details of a specific blog post by its ID. This endpoint returns a detailed object representing the blog post.",
     *  @OA\Parameter(
     *      name="post",
     *      in="path",
     *      description="ID of the post to retrieve",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Post retrieved successfully",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="Post retrieved successfully"
     *          ),
     *          @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/PostResource"
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Post not found",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="Resource not found"
     *          )
     *      )
     *  ),
     * )
    */
    public function show(Post $post): JsonResponse
    {
        return $this->successResponse('Post retrieved successfully', new PostResource($post), 200);
    }

    /**
     * @OA\Put(
     *  path="/api/v1/posts/{post}",
     *  tags={"Posts"},
     *  summary="Update an Existing Blog Post",
     *  description="Update an existing blog post with the provided details. This endpoint requires authentication.",
     *  security={{"sanctum": {}}},
     *  @OA\Parameter(
     *      name="post",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer"),
     *      description="ID of the post to update"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string", example="Updated Post Title"),
     *          @OA\Property(property="slug", type="string", example="updated-post-title"),
     *          @OA\Property(property="content", type="string", example="This is the updated content of the post."),
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Post updated successfully",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="Post updated successfully"
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="error",
     *              type="string",
     *              example="Unauthorized, you must log in first"
     *          )
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Post not found",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Resource not found")
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Unprocessable",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Validation error"),
     *          @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}}),
     *      )
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Internal server error",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Failed to update post")
     *      )
     *  )
     * )
    */
    public function update(PostFormRequest $request, Post $post): JsonResponse
    {
        try {
            $post->title = $request->input('title');
            $post->slug = $request->input('slug');
            $post->content = $request->input('content');
            $post->save();

            return $this->successResponse('Post updated successfully', null, 200);
        } catch (\Exception $e) {
            Log::error('Error updating resource ' . $e->getMessage() . ' In Line: ' . $e->getLine());
            return $this->errorResponse('Failed to update post', 500);
        }
    }

    /**
     * @OA\Delete(
     *  path="/api/v1/posts/{post}",
     *  tags={"Posts"},
     *  summary="Delete a Blog Post",
     *  description="Delete a blog post by its ID. This endpoint requires authentication.",
     *  security={{"sanctum": {}}},
     *  @OA\Parameter(
     *      name="post",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer"),
     *      description="ID of the post to delete"
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="No Content: Post deleted successfully",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Unauthorized, you must log in first")
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Post not found",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Resource not found")
     *      )
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Internal server error",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Failed to delete post")
     *      )
     *  )
     * )
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
