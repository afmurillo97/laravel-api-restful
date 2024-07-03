<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content'
    ];

    protected $guarded = [
        
    ];

    public function getExcerptAttribute()
    {
        return substr($this->content, 0, 120);
    }

    public function getPublishedAtAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function user() 
    {
        return $this->belongsTo(User::class); 
    }
}
