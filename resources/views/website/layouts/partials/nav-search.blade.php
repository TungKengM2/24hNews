<div class="nav-search-style1">
    <div class="row justify-content-center align-items-center gx-lg-5">
        <div class="col-lg-4">
            <div class="info">
                <h5>you can search by category <br> or news title</h5>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="form" method="POST" action="{{ route('search') }}">
                @csrf
                <span class="color-777 fst-italic text-capitalize mb-2 fsz-13px">Enter Keyword</span>
                <div class="form-group">
                    <span class="icon">
                        <i class="la la-search"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control" 
                           placeholder="Elon Musk ..." 
                           value="{{ old('keyword', $keyword ?? '') }}">
                    <button type="submit">search</button>
                </div>
            </form>

            {{-- // dat thêm --}}
            <!-- Hiển thị kết quả tìm kiếm ngay tại trang home -->
            @if(isset($results))
            <div class="search-results mt-4">
                <h6>Kết quả tìm kiếm cho: "{{ $keyword }}"</h6>
                @if($results->count() > 0)
                    <ul>
                        @foreach($results as $result)
                            <li>{{ $result->title }} 
                                <a href="{{ Auth::check() ? route('client.articles.article', $result->article_id) : url('/login-user') }}" class="btn btn-sm btn-primary">Xem</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Không tìm thấy kết quả nào.</p>
                @endif
            </div>
        @endif
        </div>
    </div>
</div>