<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotificatons(){
        return[
            'read' => auth()->user()->readNotifications,
            'unread' => auth()->user()->unreadNotifications,
            'usertype' => auth()->user()->roles->first()->name, 

        ];
    }
    public function markAsRead(Request $request){
        return auth()->user()->notifications->where('id',$request->id)->markAsRead();


    }
    public function markAsReadAndRedirect($id){
        $notification=auth()->user()->notifications->where('id',$id)->first();

        $notification->markAsRead();
        if(auth()->user()->roles->first()->name == 'user'){
            if($notification->type=='App\Notifications\NewCommentForPostOnerNotifiy'){
                return redirect()->route('post.show',$notification->data['post_slug']);
            }else{
                return redirect()->back();
            }
        }


    }


}
