@extends('layouts.app')

@section('content')

 <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				{!!Form::open(['route'=>'frontend.user.updateuser','name'=>'update_info','method'=>'post','files'=>true])!!}
        				<div class="row">
        					<div class="col-3">
        						<div class="form-group">
        				{!!Form::label('name','Name')!!}
        				{!!Form::text('name',old('name',auth()->user()->name),['class'=>'form-control'])!!}	
        				@error('name')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        						
        					</div>
        					<div class="col-3">
        						<div class="form-group">
        				{!!Form::label('email','Email')!!}
        				{!!Form::text('email',old('email',auth()->user()->email),['class'=>'form-control'])!!}	
        				@error('email')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        					</div>
        					
                            <div class="col-3">
                                <div class="form-group">
                        {!!Form::label('mobile','Mobile')!!}
                        {!!Form::text('mobile',old('mobile',auth()->user()->mobile),['class'=>'form-control'])!!} 
                        @error('mobile')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                            </div>
        					<div class="col-3">
        						{!!Form::label('recive_email','Recive Email')!!}
        				{!!Form::select('recive_email',['1'=>'yes','0'=>'no'],old('recive_email',auth()->user()->recive_email),['class'=>'form-control'])!!}	
        				@error('recive_email') <span class="text-danger">{{$message}}</span>@enderror
        					</div>

        				</div>
        				

        				<div class="row">
        					<div class="col-12">
        						<div class="form-group">
        				{!!Form::label('bio','Bio')!!}
        				{!!Form::textarea('bio',old('bio',auth()->user()->bio),['class'=>'form-control'])!!}	
        				@error('bio')<span class="text-danger">{{$message}}</span>@enderror
        				</div>
        					</div>
        				</div>

                        <div class="row">
                            @if(auth()->user()->userimage != '')
                            <div class="col-12">
                                <img src="{{asset('assets/users/'. auth()->user()->userimage)}}" class="img-fluid" width="150px" alt="{{auth()->user()->name}}">
                            </div>

                            @endif
                            <div class="col-12">
                                <div class="form-group">
                        {!!Form::label('userimage','User Image')!!}
                        {!!Form::file('userimage',['class'=>'custom-file'])!!}  
                        @error('userimage')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                            </div>
                        </div>

        				
        				<div class="form-group pt-4">
        					{!!Form::submit('Update User',['class'=>'btn btn-primary'])!!}
        				</div>
        				{!!Form::close()!!}
                        <hr>

                        {!!Form::open(['route'=>'frontend.user.updatepassword','name'=>'update_password','method'=>'post'])!!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                        {!!Form::label('current_password','Current Password')!!}
                        {!!Form::password('current_password',['class'=>'form-control'])!!}  
                        @error('current_password')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                                
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                        {!!Form::label('password','New Password')!!}
                        {!!Form::password('password',['class'=>'form-control'])!!}   
                        @error('password')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                            </div>
                            
                            <div class="col-4">
                                <div class="form-group">
                        {!!Form::label('password_confirmation','Re Password')!!}
                        {!!Form::password('password_confirmation',['class'=>'form-control'])!!} 
                        @error('password_confirmation')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                            </div>
                            

                        </div>
                        
                        
                        <div class="form-group pt-4">
                            {!!Form::submit('Update Password',['class'=>'btn btn-primary'])!!}
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


