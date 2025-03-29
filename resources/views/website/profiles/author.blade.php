@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($author->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($author->role->name) }}</p>
                        @endif
                        <h2> {{ $author->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->

        <!-- ====== start author-details ====== -->
        <section class="tc-author-details py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <div class="author-img mb-3 mb-md-0">
                                            <img src="{{ $author->image ? asset('storage/' . $author->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' }}"
                                                alt="{{ $author->username }}" class="img-fluid rounded-circle" style="width: 180px; height: 180px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="info">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="rate me-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($averageRating))
                                                            <i class="la la-star text-warning"></i>
                                                        @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                                                            <i class="la la-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="la la-star-o text-secondary"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-muted">({{ number_format($averageRating, 1) }})</span>
                                            </div>
                                            
                                            <div class="description mb-4">
                                                <p class="lead mb-3">{{ $author->description ?? 'Không có mô tả trang cá nhân' }}</p>
                                                <div class="d-flex flex-wrap align-items-center text-muted">
                                                    <div class="me-4 mb-2">
                                                        <i class="la la-book me-1"></i> {{ $author->articles_count }} bài viết
                                                    </div>
                                                    <div class="me-4 mb-2">
                                                        <i class="la la-user me-1"></i> {{ $followerCount }} người theo dõi
                                                    </div>
                                                    <div class="mb-2">
                                                        <i class="la la-calendar me-1"></i> Tham gia từ {{ $author->created_at->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="follow">
                                                @if (auth()->check() && auth()->id() !== $author->user_id)
                                                    @if (auth()->user()->following()->where('following_id', $author->user_id)->exists())
                                                        <form action="{{ route('user.unfollow', $author->user_id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger">
                                                                <i class="la la-user-minus me-1"></i> Bỏ theo dõi
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('user.follow', $author->user_id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-user-plus me-1"></i> Theo dõi
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                            
                                            <div class="social-links mt-3">
                                                <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="la la-facebook-f"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-info me-2"><i class="la la-twitter"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-danger me-2"><i class="la la-instagram"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-dark"><i class="la la-linkedin"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author-details ====== -->

        <!-- ====== start author-post ====== -->
        <section class="tc-author-post py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Bài viết của {{ $author->username }}</h3>
                        </div>

                        @if ($author->articles->count() > 0)
                            <div class="row">
                                @foreach ($author->articles as $article)
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 240px; object-fit: cover;">
                                                <div class="position-absolute top-0 start-0 m-3">
                                                    <span class="badge bg-primary">{{ $article->category->name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title mb-3">
                                                    <a href="{{ route('articles.article', $article->slug) }}" class="text-decoration-none text-dark">
                                                        {{ $article->title }}
                                                    </a>
                                                </h4>
                                                <p class="card-text text-muted">
                                                    {{ Str::limit(strip_tags($article->content), 120) }}
                                                </p>
                                            </div>
                                            <div class="card-footer bg-white border-0 pt-0">
                                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                                    <div>
                                                        <i class="la la-calendar me-1"></i> {{ $article->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div>
                                                        <i class="la la-eye me-1"></i> {{ $article->views ?? 0 }} lượt xem
                                                        <span class="mx-2">|</span>
                                                        <i class="la la-comment me-1"></i> {{ $article->comments->count() }} bình luận
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="#" class="btn btn-outline-primary">Xem thêm bài viết</a>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="la la-info-circle me-2"></i> Tác giả chưa có bài viết nào.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author-post ====== -->
          <!-- ====== start modals ====== -->

          <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
          aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header">
              <div class="logo">
                  <h1>News24h</h1>
              </div>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                  aria-label="Close"></button>
          </div>
          <div class="offcanvas-body mt-4">
              <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold"> Giới Thiệu News24h <i class="la la-angle-right ms-1"></i>
              </h6>
              <div class="text mb-4">
                  News24h là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật 24/7. 
                  Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
              </div>
  
              <div class="mt-4">
                  <h6 class="color-000 mb-3 fw-bold">Tại sao chọn News24h?</h6>
                  <div class="d-flex align-items-center mb-3">
                      <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                          <i class="la la-newspaper-o text-primary"></i>
                      </div>
                      <div>
                          <p class="mb-0">Tin tức chính xác, đa chiều</p>
                      </div>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                      <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                          <i class="la la-bolt text-primary"></i>
                      </div>
                      <div>
                          <p class="mb-0">Cập nhật tin tức 24/7</p>
                      </div>
                  </div>
                  <div class="d-flex align-items-center mb-4">
                      <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                          <i class="la la-users text-primary"></i>
                      </div>
                      <div>
                          <p class="mb-0">Cộng đồng độc giả lớn mạnh</p>
                      </div>
                  </div>
              </div>
  
              <div class="sidebar-contact-info mt-4 pt-4 border-top">
                  <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold"> Liên Hệ & Theo Dõi <i
                          class="la la-angle-right ms-1"></i> </h6>
                  <ul class="m-0">
                      <li class="mb-3">
                          <i class="las la-map-marker me-2 color-main fs-5"></i>
                          <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</a>
                      </li>
                      <li class="mb-3">
                          <i class="las la-envelope me-2 color-main fs-5"></i>
                          <a href="#">bayanhtai@gmail.com</a>
                      </li>
                      <li class="mb-3">
                          <i class="las la-phone-volume me-2 color-main fs-5"></i>
                          <a href="#">0981 725 836</a>
                      </li>
                  </ul>
                  <div class="social-links mt-3">
                      <a href="#" class="me-2">
                          <i class="la la-twitter"></i>
                      </a>
                      <a href="#" class="me-2">
                          <i class="la la-facebook-f"></i>
                      </a>
                      <a href="#" class="me-2">
                          <i class="la la-instagram"></i>
                      </a>
                      <a href="#" class="me-2">
                          <i class="la la-youtube"></i>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <!-- ====== end modals ====== -->
    </main>
@endsection