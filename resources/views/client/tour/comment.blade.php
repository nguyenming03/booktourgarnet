   <div class="row">
       <div class="container bootdey">
           <div class="col-md-12 bootstrap snippets">
               <!-- Hiển thị form bình luận nếu người dùng đã đặt tour -->
               @if ($userHasBooked)
                   <div class="panel">
                       <div class="panel-body">

                       </div>
                   </div>
               @else
                   <!-- Hiển thị thông báo nếu chưa đặt tour -->
               @endif

               <!-- Hiển thị danh sách bình luận -->
               @foreach ($comments as $comment)
                   <div class="panel">
                       <div class="panel-body">
                           <div class="media-block">
                               <a class="media-left" href="#">
                                   <img class="img-circle img-sm" alt="Profile Picture"
                                       src="{{ Storage::url($comment->user->avatar) }}">
                               </a>
                               <div class="media-body">
                                   <div class="mar-btm">
                                       <strong class="btn-link text-semibold media-heading box-inline">
                                           {{ $comment->user ? $comment->user->name : 'Ẩn danh' }}
                                       </strong>
                                       <p class="text-muted text-sm">
                                           <i class="fa fa-clock-o"></i> {{ $comment->created_at }}
                                       </p>
                                   </div>
                                   <p>{{ $comment->content }}</p>
                                   <div class="pad-ver">
                                       <div class="btn-group">
                                           <a class="btn btn-sm btn-default btn-hover-success" href="#"><i
                                                   class="fa fa-thumbs-up"></i></a>
                                           <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i
                                                   class="fa fa-thumbs-down"></i></a>
                                       </div>
                                       <!-- Nút Trả lời -->
                                       @if ($userHasBooked)
                                           <button class="btn btn-sm btn-default btn-hover-primary"
                                               onclick="toggleReplyForm({{ $comment->id }})">Trả lời</button>
                                       @else
                                           <span class="text-muted">Chỉ người đã đặt tour mới có thể trả lời.</span>
                                       @endif
                                   </div>
                                   <hr>
                                   <!-- Hiển thị bình luận con -->
                                   @if ($comment->children->count())
                                       @include('client.tour.comment', ['comments' => $comment->children])
                                   @endif
                                   <!-- Form trả lời bình luận -->
                                   @if ($userHasBooked)
                                       <div id="reply-form-{{ $comment->id }}" class="mt-3" style="display: none;">
                                           <form method="POST" action="{{ route('posts.comment', $tour->id) }}">
                                               @csrf
                                               <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                               <textarea class="form-control" name="content" rows="2" placeholder="Trả lời bình luận này" required></textarea>
                                               <button class="btn btn-primary btn-sm mt-2" type="submit">Gửi trả
                                                   lời</button>
                                           </form>
                                       </div>
                                   @endif
                               </div>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
       </div>
   </div>
