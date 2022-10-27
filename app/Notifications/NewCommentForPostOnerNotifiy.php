<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommentForPostOnerNotifiy extends Notification implements ShouldQueue,ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $comment;
    public function __construct($comment)
    {
        $this->comment=$comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $arr= ['database','broadcast'];
        if($notifiable->recive_email == 1){
            $arr[]='mail';
        }
        return $arr;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('this new comment from '.$this->comment->name . 'on your post '. $this->comment->post->title)
                    ->action('go to your post ', route('frontend.user.editcomment',$this->comment->id))
                    ->line('Thank you for using our Bloggi system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        
        return [
            'id' =>$this->comment->id,
            'name' =>$this->comment->name,
            'email' =>$this->comment->email,
            'url' =>$this->comment->url,
            'comment' =>$this->comment->comment,
            'post_id' =>$this->comment->post_id,
            'post_title' =>$this->comment->post->title,
            'post_slug' =>$this->comment->post->slug,
            'created_at' =>$this->comment->created_at->format('d M,Y h:i a'),
            
        ];
    }

     public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' =>[
            'id' =>$this->comment->id,
            'name' =>$this->comment->name,
            'email' =>$this->comment->email,
            'url' =>$this->comment->url,
            'comment' =>$this->comment->comment,
            'post_id' =>$this->comment->post_id,
            'post_title' =>$this->comment->post->title,
            'post_slug' =>$this->comment->post->slug,
            'created_at' =>$this->comment->created_at->format('d M,Y h:i a'),
           ], 
            
        ]);
    }
    
}
