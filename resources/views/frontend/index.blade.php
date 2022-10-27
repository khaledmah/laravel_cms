@extends('layouts.app')

@section('content')

 <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				<div class="blog-page">
        					<div class="page__header">
        						<h2>Category Archives: HTML</h2>
        					</div>
        					<!-- Start Single Post -->
        					@forelse($posts as $post)
        					<article class="blog__post d-flex flex-wrap">
        						<div class="thumb">
        							<a href="{{route('post.show',$post->slug)}}">
        								@if($post->media->count() > 0)
        								<img width="100px" height="100px" src="{{'assets/posts/'.$post->media->first()->file_name}}" alt="{{$post->title}}">
        								@else
        								<img src="{{asset('assets/posts/default.jpg')}}" alt="{{$post->title}}">

        								@endif

        							</a>
        						</div>
        						<div class="content">
        							<h4><a href="{{route('post.show',$post->slug)}}">{{$post->title}}</a></h4>
        							<ul class="post__meta">
        								<li>Posts by : <a href="#">{{$post->user->name}}</a></li>
        								<li class="post_separator">/</li>
        								<li>{{$post->created_at->format('M d Y H:i')}}</li>
        							</ul>
        							<p>{!! Str::limit($post->description,145,'...')!!}</p>
        							<div class="blog__btn">
        								<a href="{{route('post.show',$post->slug)}}">read more</a>
        							</div>
        						</div>
        					</article>

        					@empty
        					<div class="text-center">no posts found</div>
        					@endforelse
        					
        					<!-- End Single Post -->
        					
        				</div>
        				{!! $posts->appends(request()->input())->links()!!}
        				
        			</div>
        			@include('partial.frontend.sidbar')
        		</div>
        	</div>
        </div>
        <!-- End Blog Area -->
}
}
@endsection
