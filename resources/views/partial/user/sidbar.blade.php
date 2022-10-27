 <div class="wn__sidebar">
        					
  <!-- Start Single Widget -->
        					
        						
   <div class="recent-posts">
    <ul>	
     <li class="list-group-item"><img src="{{asset('assets/users/'.auth()->user()->userimage)}}" alt="{{auth()->user()->name}}"></li>
     <li class="list-group-item"><a href="{{route('frontend.dashboard')}}">My Posts</a></li>
     <li class="list-group-item"><a href="{{route('frontend.user.createpost')}}">Create Post</a></li>
     <li class="list-group-item"><a href="{{route('frontend.user.comments')}}">Manage Comments</a></li>
     <li class="list-group-item"><a href="{{route('frontend.user.edituser')}}">Update Information</a></li>
     <li class="list-group-item"><a href="{{ route('logout') }}"onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">Logout</a></li>
     
     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf </form>


    </ul>
   </div>
  <!-- End Single Widget -->
        				
        				
 </div>
</div>