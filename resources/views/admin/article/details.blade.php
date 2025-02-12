<!-- admin/article/partials/detail.blade.php -->
<h5 class="card-title">{{ $article->title }}</h5>
<p><strong>Hình ảnh:</strong> <img src="{{ Storage::url($article->img_thumb) }}" alt="{{ $article->name }}" class="img-fluid"></p>
<p><strong>Mô tả:</strong> {{ $article->description }}</p>
<p><strong>Nội dung:</strong> {!! $article->content !!}</p>
<p><strong>Danh mục:</strong> {!! $article->category->name !!}</p>
<p><strong>Trạng thái:</strong> 
    @if ($article->status == 1)
        <span >Hiển Thị</span>
    @else
        <span >Ẩn</span>
    @endif
</p>
<p><strong>Người đăng:</strong> {!! $article->user->name !!}</p>
<p><strong>Ngày đăng:</strong> {!! $article->created_at !!}</p>
<p><strong>Ngày cập nhật:</strong> {!! $article->updated_at !!}</p>

