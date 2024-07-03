<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * @OA\Schema(
     *  schema="PostResource",
     *  type="object",
     *  title="Post",
     *  description="Post resource",
     *  @OA\Property(
     *      property="title",
     *      type="string",
     *      description="Title of the Post"
     *  ),
     *  @OA\Property(
     *      property="slug",
     *      type="string",
     *      description="Slug for the Post"
     *  ),
     *  @OA\Property(
     *      property="excerpt",
     *      type="string",
     *      description="Excerpt of the Post"
     *  ),
     *  @OA\Property(
     *      property="content",
     *      type="string",
     *      description="Content of the Post"
     *  ),
     * )
    */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content
        ];
    }
}
