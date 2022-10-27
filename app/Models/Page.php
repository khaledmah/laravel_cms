<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\User;
use App\Models\Category;
use App\Models\PostMedia;
class Page extends Model
{
    use Sluggable;
    protected $table='posts';
    protected $guarded = [];

      public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }

     public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function media(){

        return $this->hasMany(PostMedia::class,'post_id','id');
    }
}
