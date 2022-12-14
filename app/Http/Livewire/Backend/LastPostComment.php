<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;
class LastPostComment extends Component
{
    public function render()
    {
        $posts=Post::wherePostType('post')->withCount('comments')->orderBy('id','desc')->take(5)->get();
        $comments=Comment::orderBy('id','desc')->take(5)->get();
        return view('livewire.backend.last-post-comment',[
            'posts' => $posts,
            'comments' => $comments,
        ]); 
    }
}
