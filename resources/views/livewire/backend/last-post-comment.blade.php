<div>
     <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Last Posts</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Commnets</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($posts as $post)
                                            <tr>
                                                <td>{{Str::limit($post->title,30,'...')}}</td>
                                                <td>{{$post->comments_count}}</td>
                                                <td>{{$post->status ? 'Active' : 'Inactive'}}</td>
                                                <td>{{$post->created_at->diffForHumans()}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">no post found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            

                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                               <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Commnet</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($comments as $comment)
                                            <tr>
                                                <td>{{$comment->name}}</td>
                                                <td>{{Str::limit($comment->comment,30,'...')}}</td>
                                                <td>{{$comment->status ? 'Active' : 'Inactive'}}</td>
                                                <td>{{$comment->created_at->diffForHumans()}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">no comment found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                         

                        </div>
                    </div>
</div>
