<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
class Statistics extends Component
{
    public function render()
    {
        $users=User::whereHas('roles',function($query){
            $query->where('name','user');
        })->whereStatus(1)->count();
        $active_post=Post::whereStatus(1)->wherePostType('post')->count();
        $unactive_post=Post::whereStatus(0)->wherePostType('post')->count();
        $active_comment=Comment::whereStatus(1)->count();
        $unactive_comment=Comment::whereStatus(0)->count();



        return view('livewire.backend.statistics',[
            'users'         => $users,
            'active_post'   => $active_post,
            'unactive_post' => $unactive_post,   
            'active_comment'    => $active_comment,
            'unactive_comment'  => $unactive_comment,

        ]);
    }
}
