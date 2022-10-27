@extends('layouts.app')

@section('content')

 <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				{!!Form::model($comment,['route'=>['frontend.user.updatecomment',$comment->id],'method'=>'put'])!!}
        				<div class="row">
        					<div class="col-3">
        						<div class="form-group">
        				{!!Form::label('name','Name')!!}
        				{!!Form::text('name',old('name',$comment->name),['class'=>'form-control'])!!}	
        				@error('name')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        						
        					</div>
        					<div class="col-3">
        						<div class="form-group">
        				{!!Form::label('email','Name')!!}
        				{!!Form::text('email',old('email',$comment->email),['class'=>'form-control'])!!}	
        				@error('email')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        					</div>
        					<div class="col-3">
        						<div class="form-group">
        				{!!Form::label('url','Url')!!}
        				{!!Form::text('url',old('url',$comment->url),['class'=>'form-control'])!!}	
        				@error('url')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        					</div>
        					<div class="col-3">
        						{!!Form::label('status','Status')!!}
        				{!!Form::select('status',['1'=>'yes','0'=>'no'],old('status',$comment->status),['class'=>'form-control'])!!}	
        				@error('status') <span class="text-danger">{{$message}}</span>@enderror
        					</div>

        				</div>
        				

        				<div class="row">
        					<div class="col-12">
        						<div class="form-group">
        				{!!Form::label('comment','Comment')!!}
        				{!!Form::textarea('comment',old('comment',$comment->comment),['class'=>'form-control'])!!}	
        				@error('comment')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        					</div>
        				</div>

        				
        				<div class="form-group pt-4">
        					{!!Form::submit('Update Comment',['class'=>'btn btn-primary'])!!}
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


