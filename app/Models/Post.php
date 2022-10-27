<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use App\Models\PostMedia;
use Nicolaslopezj\Searchable\SearchableTrait;
class Post extends Model
{
    
    use Sluggable,SearchableTrait;
    protected $guarded = [];

     protected $searchable = [
        'columns' => [
            'title' => 10,
            'description' => 10,
            
        ],
    ];

      public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category(){

        return $this->belongsTo(Category::class);
    }

     public function user(){

        return $this->belongsTo(User::class);
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }
     public function approved_comments(){

        return $this->hasMany(Comment::class)->whereStatus(0);
    }

    public function media(){

        return $this->hasMany(PostMedia::class);
    }

}
