<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewCommentForPostOnerNotifiy;
class IndexController extends Controller
{
    public function index(){

         
        $posts=Post::with(['category','media','user'])
        ->whereHas('category',function ($query)
            {
                $query->whereStatus(1);})
         ->whereHas('user',function ($query)
            {
                $query->whereStatus(1);
            })
        ->wherePostType('post')->whereStatus(1)->orderBy('id','desc')->paginate(5);
        
        return view('frontend.index',compact('posts'));

    }

    public function category($slug){

        $category=Category::whereSlug($slug)->whereStatus(1)->first()->id;
        if($category){
            $posts=Post::with(['category','media','user'])
            ->withCount('approved_comments')
            ->whereStatus(1)
            ->wherePostType('post')
            ->whereCategoryId($category)
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index',compact('posts'));
        }
        return redirect()->route('frontend.index');
    }

    public function archive($date){
        $exploded_date=explode('-', $date);
        $month=$exploded_date[0];
        $year=$exploded_date[1];

        $posts=Post::with(['category','media','user'])
        ->withCount('approved_comments')
        ->whereStatus(1)
        ->wherePostType('post')
        ->whereMonth('created_at',$month)
        ->whereYear('created_at',$year)
        ->orderBy('id','desc')
        ->paginate(5);
        return view('frontend.index',compact('posts'));
        
    }

    public function author($username){
        $users=User::whereUsername($username)->whereStatus(1)->first()->id;
        if($users){
            $posts=Post::with(['category','media','user'])
            ->withCount('approved_comments')
            ->whereStatus(1)
            ->wherePostType('post')
            ->whereUserId($users)
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index',compact('posts'));
        }
        return redirect()->route('frontend.index');
    }
     public function post_show($slug)
     {

        $post=Post::with(['category','media','user','approved_comments'=>function($query){

            $query->orderBy('id','desc');
        }]);
         
        $post=$post->whereHas('category',function ($query)
            {
                $query->whereStatus(1);})
         ->whereHas('user',function ($query)
            {
                $query->whereStatus(1);
            });

        $post=$post->whereSlug($slug)->whereStatus(1)->first();
        if ($post) {
            $blade= $post->post_type == 'post' ? 'post' : 'page';
            return view('frontend.'.$blade,compact('post'));
        }
        else{

        return redirect()->route('frontend.index');

        }

        

    }
          public function post_comment(Request $request,$slug){


        $validation=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'url'=>'nullable|url',
            'comment'=>'required|string|min:10',
        ]);


        if($validation->fails()){
            
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post=Post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();
        if($post){
        
            $userId=auth()->check()? auth()->user()->id : null;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['url']=$request->url;
        $data['ip_address']=$request->ip();
        $data['comment']=$request->comment;
        $data['post_id']=$post->id;
        $data['user_id']=$userId;

        $comment=$post->comments()->create($data);
        if(auth()->guest() || auth()->id() != $post->user_id){
            $post->user->notify(new NewCommentForPostOnerNotifiy($comment));
            // dd($post->user->notifications);
        }

        // Comment::create($data);
        return redirect()->back()->with([
        'message'=>'comment added successfuly',
        'alert-type'=>'success'

    ]);
    }

    return redirect()->back()->with([
        'message'=>'something was wrong',
        'alert-type'=>'danger'

    ]);

     }
     public function contact_show(){
        return view('frontend.contact');
     }

     public function post_contact(Request $request){
         $validation=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'title'=>'required|string|min:10',
            'mobile'=>'nullable|numeric',
            'message'=>'required|string|min:10',
            
        ]);


        if($validation->fails()){
            
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['title']=$request->title;
        $data['mobile']=$request->mobile;
        $data['message']=$request->message;

        $contact=Contact::create($data);

        if($contact){
             return redirect()->back()->with([
        'message'=>'contact added successfuly',
        'alert-type'=>'success'

    ]);
        }
        return redirect()->back()->with([
        'message'=>'something was wrong',
        'alert-type'=>'danger'

    ]);


        


     }

     public function search(Request $request){

        $keyword=isset($request->keyword) && $request->keyword != '' ? $request->keyword : null; 

        $posts=Post::with(['category','media','user'])
        ->whereHas('category',function ($query)
            {
                
                $query->whereStatus(1);})
         ->whereHas('user',function ($query)
            {
                $query->whereStatus(1);
            });

         if($keyword != null){


         $posts = $posts->search($keyword, null, true);
         }
        $posts=$posts->wherePostType('post')->whereStatus(1)->orderBy('id','desc')->paginate(5);
        
        return view('frontend.index',compact('posts'));
        
     }
}
