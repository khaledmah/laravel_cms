@extends('layouts.app')

@section('content')

<div class="page-blog-details section-padding--lg bg--white">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-12">
						<div class="blog-details content">
							<article class="blog-post-details">
								<div class="post-thumbnail">
									<img src="{{asset('frontend/images/blog/big-img/1.jpg')}}" alt="blog images">
								</div>
								<div class="post_wrapper">
									<div class="post_header">
										<h2>{{$post->title}}</h2>
										<div class="blog-date-categori">
											<ul>
												<li>{{$post->created_at->format('M d,Y H:i a')}}</li>
												<li><a href="#" title="Posts by {{$post->user->name}}" rel="author">{{$post->user->name}}</a></li>
											</ul>
										</div>
									</div>
									<div class="post_content">
										<p>{!! Str::limit($post->description,145,' ...')!!}</p>
									</div>
									
								</div>
							</article>
							
							
						</div>
					</div>
					
				</div>
			</div>
		</div>


@endsection