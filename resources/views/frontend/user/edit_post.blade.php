@extends('layouts.app')
@section('style')

<link rel="stylesheet" type="text/css" href="{{asset('frontend/js/summernote/summernote-bs4.min.css')}}">
@endsection
@section('content')

 <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				{!!Form::model($post,['route'=>['frontend.user.updatepost',$post->id],'method'=>'put','files'=>true,'enctype'=>'multipart/form-data'])!!}

        				<div class="form-group">
        				{!!Form::label('title','Title')!!}
        				{!!Form::text('title',old('title',$post->title),['class'=>'form-control'])!!}	
        				@error('title')<span class="text-danger">{{$message}}</span>@enderror
        				</div>

        				<div class="form-group">
        				{!!Form::label('description','Descrption')!!}
        				{!!Form::textarea('description',old('description',$post->description),['class'=>'form-control summernote'])!!}	
        				@error('description') <span class="text-danger">{{$message}}</span>@enderror
        				</div>

        				<div class="row">
        					<div class="col-4">
        						{!!Form::label('category_id','Category id')!!}
        				{!!Form::select('category_id',[''=>'---']+$category->toArray(),old('category_id',$post->category_id),['class'=>'form-control'])!!}	
        				@error('category_id') <span class="text-danger">{{$message}}</span>@enderror
        					</div>
        					<div class="col-4">
        						{!!Form::label('comment_able','Comment able')!!}
        				{!!Form::select('comment_able',['1'=>'active','0'=>'inactive'],old('comment_able',$post->comment_able),['class'=>'form-control'])!!}	
        				@error('comment_able') <span class="text-danger">{{$message}}</span>@enderror
        					</div>
        					<div class="col-4">
        						{!!Form::label('status','Status')!!}
        				{!!Form::select('status',['1'=>'yes','0'=>'no'],old('status',$post->status),['class'=>'form-control'])!!}	
        				@error('status') <span class="text-danger">{{$message}}</span>@enderror
        					</div>
        				</div>
        				<div class="row pt-4">
        					<div class="col-12">
        						<div class="file-loading">
        				
        				{!!Form::file('images[]',['id'=>'post_images','multiple'=>'multiple'])!!}	
        				
        				</div>
        					</div>
        				</div>
        				
        				<div class="form-group pt-4">
        					{!!Form::submit('Update Post',['class'=>'btn btn-primary'])!!}
        				</div>
        				{!!Form::close()!!}
        				
        			</div>
                            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                                   
        			@include('partial.user.sidbar')
                            </div>
        		</div>
        	</div>
        </div>
        <!-- End Blog Area -->

@endsection
@section('script')
<script type="text/javascript" src="{{asset('frontend/js/summernote/summernote-bs4.min.js')}}"></script>
<script>
	$(function(){
		$('.summernote').summernote({
        placeholder: 'post descrption',
        tabsize: 2,
        height: 100,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
		$("#post_images").fileinput({
			// theme:fa4,
			maxFileCount:5,
			allowedFileType:['image'],
			showCancel:true,
			showRomove:true,
			showUplode:false,
			overwrittenInitial:false,
			initialPreview:[
			@if($post->count() > 0)
				@foreach($post->media as $media)

				"{{asset('assets/posts/'.$media->file_name)}}",

				@endforeach
			@endif

			],
			initialPreviewAsData:true,
			initialPreviewFileType:'image',
			initialPreviewConfig:[

			@if($post->count() > 0)
				@foreach($post->media as $media)

				{caption:"{{$media->file_name}}",size:"{{$media->file_size}}",width:"120px",url:"{{route('frontend.user.postmediadestroy',[$media->id,'_token'=>csrf_token()])}}",key:"{{$media->id}}"},

				@endforeach
			@endif

			],


		});

	});
</script>
@endsection
