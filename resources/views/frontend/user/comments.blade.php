@extends('layouts.app')

@section('content')

 <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				<div class="table-responsive">
                                          <table class="table">
                                                 <thead>
                                                        <tr>
                                                        <th>name</th>
                                                        <th>post</th>
                                                        <th>status</th>
                                                        <th>action</th>
                                                        </tr>
                                                 </thead>
                                                 <tbody>
                                                        @forelse($comments as $comment)
                                                        <tr>
                                                        <td>{{$comment->name}}</td>
                                                        <td>{{$comment->post->title}}</td>
                                                        <td>{{$comment->status}}</td>
                                                        <td><a href="{{route('frontend.user.editcomment',$comment->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>

                                                               <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="if (confirm('are you sure to delete?')){document.getElementById('comment-delete-{{$comment->id}}').submit();}else{
                                                                      return 0;
                                                               }"><i class="fa fa-trash"></i></a>

                                                               <form action="{{route('frontend.user.commentdestroy',$comment->id)}}" id="comment-delete-{{$comment->id}}" method="POST">
                                                                      @csrf
                                                                      @method('DELETE')
                                                               </form>
                                                        </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                               <td colspan="4">no comments found.</td>
                                                        </tr>
                                                        @endforelse
                                                 </tbody>
                                                 <tfoot><tr>
                                                        <td colspan="4">{!!$comments->appends( request()->input())->links()!!}</td>
                                                 </tr></tfoot>
                                          </table>
                                   </div>
        				
        			</div>
                            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                                   
        			@include('partial.user.sidbar')
                            </div>
        		</div>
        	</div>
        </div>
        <!-- End Blog Area -->
}
}
@endsection
