<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }
    public function index(){
        $posts=auth()->user()->posts()->with(['category','media','user'])->withCount('comments')->orderBy('id','desc')->paginate(10);

        return view('frontend.user.dashboard',compact('posts'));
    }

    public function create_post(){
        $category=Category::whereStatus(1)->pluck('name','id');
        return view('frontend.user.create_post',compact('category'));
    }
    public function store_post(Request $request){

        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required|min:20',
            'category_id'=>'required',
            'comment_able'=>'required',
            'status'=>'required',

        ]);
        if($validator->fails()){
            dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title']=$request->title;
        $data['description']=$request->description;
        $data['category_id']=$request->category_id;
        $data['comment_able']=$request->comment_able;
        $data['status']=$request->status;

        $post=auth()->user()->posts()->create($data);

        if($request->images && count($request->images) > 0){
            $i=1;
            foreach ($request->images as $file) {
                $filename=$post->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size=$file->getSize();
                $file_type=$file->getMimetype();
                $path=public_path('assets/posts/'.$filename);
                Image::make($file->getRealPath())->resize(800,null,function($constants)
                {
                    $constants->aspectRatio();
                })->save($path,100);
                $post->media()->create([
                    'file_name'=>$filename,
                    'file_size'=>$file_size,
                    'file_type'=>$file_type,

                  ]);
                $i++;
            }


        }
        if($request->status==1){
            Cache::forget('recent_posts');
        }



        return redirect()->back()->with([
            'message'=>'post created successfully',
            'alert-type' =>'success',
        ]);
    }


    public function edit_post($post_id){
        $post=Post::whereSlug($post_id)->orWhere('id',$post_id)->whereUserId(auth()->user()->id)->first();
        if($post){
        $category=Category::whereStatus(1)->pluck('name','id');
        return view('frontend.user.edit_post',compact('category','post'));     
        }

        return redirect()->route('frontend.index');

       
    }
    public function update_post(Request $request,$post_id){

         $validator=Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required|min:20',
            'category_id'=>'required',
            'comment_able'=>'required',
            'status'=>'required',

        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post=Post::whereSlug($post_id)->orWhere('id',$post_id)->whereUserId(auth()->user()->id)->first();
        if($post){
             $data['title']=$request->title;
             $data['description']=$request->description;
             $data['category_id']=$request->category_id;
             $data['comment_able']=$request->comment_able;
             $data['status']=$request->status;

             $post->update($data);
              if($request->images && count($request->images) > 0){
            $i=1;
            foreach ($request->images as $file) {
                $filename=$post->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
                $file_size=$file->getSize();
                $file_type=$file->getMimetype();
                $path=public_path('assets/posts/'.$filename);
                Image::make($file->getRealPath())->resize(800,null,function($constants)
                {
                    $constants->aspectRatio();
                })->save($path,100);
                $post->media()->create([
                    'file_name'=>$filename,
                    'file_size'=>$file_size,
                    'file_type'=>$file_type,

                  ]);
                $i++;
            }
        }
        return redirect()->back()->with([
            'message'=>'post updated successfully',
            'alert-type' =>'success',
        ]);
    }
    return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);


    }

    public function post_media_destroy($media_id){
        $media=PostMedia::whereId($media_id)->first();
        if($media){
            if(File::exists('assets/posts/'.$media->file_name)){
                unlink('assets/posts/'.$media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }

    public function post_destroy($post_id){
     $post=Post::whereSlug($post_id)->orWhere('id',$post_id)->whereUserId(auth()->user()->id)->first();

     if(count($post->media) > 0){
        foreach($post->media as $media){
            if(File::exists('assets/posts/'.$media->file_name)){
                unlink('assets/posts/'.$media->file_name);
            }

        }
        $post->delete();
        return redirect()->back()->with([
            'message'=>'post deleted successfully',
            'alert-type' =>'success',
        ]);
     }
     return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);



    }

   public function show_comments(Request $request){
    $comments=Comment::query();
    if(isset($request->post) && $request->post != ''){
        $comments=$comments->where('post_id',$request->post);
        

    }else{
         $posts_id=auth()->user()->posts->pluck('id')->toArray();
         $comments=$comments->whereIn('post_id',$posts_id)->paginate(10);

    }
    $comments=$comments->orderBy('id','desc');
     $comments=$comments->paginate(5);


   
    
    return view('frontend.user.comments',compact('comments'));
   }

   public function edit_comment($comment_id){
    $comment=Comment::whereId($comment_id)->whereHas('post',function($query){
        $query->where('user_id',auth()->id());
    })->first();
    if($comment){
        return view('frontend.user.edit_comment',compact('comment'));
    }
     return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);


   }

   public function update_comment(Request $request,$comment_id){
     $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'url'=>'nullable',
            'comment'=>'required',
            'status'=>'required',

        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment=Comment::whereId($comment_id)->whereHas('post',function($query){
        $query->where('user_id',auth()->id());
         })->first();
    if($comment){

             $data['name']=$request->name;
             $data['comment']=$request->comment;
             $data['email']=$request->email;
             $data['url']=$request->url !='' ? $request->url : null;
             $data['status']=$request->status;
             

             $comment->update($data);

             if($request->status==1){
                Cache::forget('recent_comments');
             }
              return redirect()->back()->with([
            'message'=>'comment updated successfully',
            'alert-type' =>'success',
        ]);
        
    }
     return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);


   }

   public function comment_destroy($comment_id){

    $comment=Comment::whereId($comment_id)->whereHas('post',function($query){
        $query->where('user_id',auth()->id());
         })->first();
    if($comment){

             $comment->delete();
             if($comment->status==1){
                Cache::forget('recent_comments');
              return redirect()->back()->with([
            'message'=>'comment updated successfully',
            'alert-type' =>'success',
        ]);
        
    }
     return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);

   }




}

public function edit_user(){

    return view('frontend.user.edit_user');
   }

   public function update_user(Request $request){
     $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required|numeric',
            'recive_email'=>'required',
            'bio'=>'nullable',
            'image'=>'nullable|image|max:20000|mimes:jpeg,jpg,png',

        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name']=$request->name;
             $data['email']=$request->email;
             $data['mobile']=$request->mobile;
             $data['bio']=$request->bio !='' ? $request->bio : null;
             $data['recive_email']=$request->recive_email;

             if($image=$request->file('userimage')){
                if(auth()->user()->userimage !=''){
                    if(File::exists('assets/users/'.auth()->user()->userimage)){
                        unlink('assets/users/'.auth()->user()->userimage);
                    }
                }
                 $filename=Str::slug(auth()->user()->usernname).'.'.$image->getClientOriginalExtension();
                $path=public_path('assets/users/'.$filename);
                Image::make($image->getRealPath())->resize(300,300,null,function($constants)
                {
                    $constants->aspectRatio();
                })->save($path,100);

                $data['userimage']=$filename;

             }
             $updated=auth()->user()->update($data);
             if($updated){
                return redirect()->back()->with([
            'message'=>'user updated successfully',
            'alert-type' =>'success',
        ]);
             }
             return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);


   }

   public function update_userpassword(Request $request){
    $validator=Validator::make($request->all(),[
            'current_password'=>'required|min:6',
            'password'=>'required|min:6|confirmed',
            
            

        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user=auth()->user();
        if(Hash::check($request->current_password,$user->password)){
           $updated=$user->update(['password'=>bcrypt($request->password)]);
            if($updated){
                return redirect()->back()->with([
            'message'=>'user updated successfully',
            'alert-type' =>'success',
        ]);
                
        }
        else{
                    return redirect()->back()->with([
            'message'=>'something was in else wrong',
            'alert-type' =>'danger',
        ]);
                }

   }
         else{
                    return redirect()->back()->with([
            'message'=>'something was wrong',
            'alert-type' =>'danger',
        ]);

}
}
}
