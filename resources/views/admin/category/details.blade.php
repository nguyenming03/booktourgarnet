<h5 class="card-title">{{ $category->name }}</h5>
<p><strong>Hình ảnh:</strong> <img src="{{ Storage::url($category->img_thumb) }}" alt="Image" width="100"></p>
<p><strong>Mô tả:</strong> {{ $category->description }}</p>  
<p><strong>Nội dung:</strong> {{ $category->content }}</p> 
<p><strong>Trạng thái:</strong> 
    @if ($category->status == 1)
        <span >Hiển Thị</span>
    @else
        <span >Ẩn</span>
    @endif
</p>
<p><strong>Người đăng:</strong> {{ $category->user->name}}</p>
<p><strong>Ngày đăng:</strong> {{ $category->created_at }}</p>
<p><strong>Ngày cập nhật:</strong> {{ $category->updated_at }}</p>
