<div class="nav-search-style1">
    <div class="row justify-content-center align-items-center gx-lg-5">
        <div class="col-lg-4">
            <div class="info">
                <h1>News24h</h1>
                <p>Kênh hóng chuyện hàng đầu Việt Nam .</p>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="form" method="GET" action="{{ route('home') }}">
                @csrf
                <span class="color-777 fst-italic text-capitalize mb-2 fsz-13px">Nhập Từ Khóa </span>
                <div class="form-group">
                    <span class="icon">
                        <i class="la la-search"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control" placeholder="Elon Musk ..." required
                        value="{{ old('keyword', $keyword ?? '') }}">
                    <button type="submit">Tìm Kiếm </button>
                </div>
                <script>
                document.querySelector('form').addEventListener('submit', function(e) {
                    const keyword = this.querySelector('input[name="keyword"]');
                    if (!keyword.value.trim()) {
                        e.preventDefault();
                        alert('Vui lòng nhập từ khóa để tìm kiếm');
                        keyword.focus();
                    }
                });
                </script>
            </form>

            {{-- Hiển thị kết quả tìm kiếm chỉ khi form đã được submit --}}
            @if (request()->has('keyword') && isset($results))
            <div class="search-results mt-4">
                <h6>Kết quả tìm kiếm cho: "{{ $keyword }}"</h6>
                @if ($results->count() > 0)
                    <ul>
                        @foreach ($results->where('status', 'published') as $result)
                            <li>
                                <a href="{{ Auth::check() ? route('articles.article', $result->slug) : url('/login-user') }}"
                                    class="btn btn-block">{{ $result->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                    @if ($results->where('status', 'published')->count() == 0)
                        <p>Không tìm thấy kết quả nào.</p>
                    @endif
                @else
                    <p>Không tìm thấy kết quả nào.</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
