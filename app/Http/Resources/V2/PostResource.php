<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
     /**
     * @OA\Schema(
     *  schema="PostResource",
     *  type="object",
     *  title="Post",
     *  description="Post resource V2",
     *  @OA\Property(
     *      property="id",
     *      type="integer",
     *      description="ID of the Post"
     *  ),
     *  @OA\Property(
     *      property="post_name",
     *      type="string",
     *      description="Name of the Post"
     *  ),
     *  @OA\Property(
     *      property="slug",
     *      type="string",
     *      description="Slug for the Post"
     *  ),
     *  @OA\Property(
     *      property="content",
     *      type="string",
     *      description="Content of the Post"
     *  ),
     *  @OA\Property(
     *      property="author",
     *      type="object",
     *      description="Author information",
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          description="Name of the author"
     *      ),
     *      @OA\Property(
     *          property="email",
     *          type="string",
     *          description="Email address of the author"
     *      )
     *  ),
     *  @OA\Property(
     *      property="created_at",
     *      type="date",
     *      description="Date of the Post"
     *  ),
     * )
    */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'post_name' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'author' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'created_at' => $this->published_at
        ];
    }
}
