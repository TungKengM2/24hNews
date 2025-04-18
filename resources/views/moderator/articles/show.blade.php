@extends('moderator.layouts.master')

@section('title')
    Chi Tiết Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Chi Tiết Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.articles.index') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Chi Tiết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Chi Tiết Bài Viết</h4>
                    <div class="box-tools">
                        <div class="btn-group">
                            @if ($article->status === 'pending')
                                <form action="{{ route('moderator.articles.approve', $article) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm" title="Duyệt bài viết"
                                        onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                        <i class="fa fa-check"></i> Duyệt bài viết
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" title="Từ chối bài viết"
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fa fa-times"></i> Từ chối
                                    </button>

                                    <a href="{{ route('moderator.articles.versions', $article) }}" class="btn btn-info btn-sm m-5">
                                        <i class="fa fa-history"></i> Lịch sử phiên bản
                                    </a>
                                    <a href="{{ route('moderator.articles.moderation-history', $article) }}"
                                        class="btn btn-info btn-sm me-2">
                                        <i class="fa fa-history"></i> Lịch sử kiểm duyệt
                                    </a>
                                    <a href="{{ route('moderator.articles.index') }}" class="btn btn-default btn-sm">
                                        <i class="mdi mdi-arrow-left"></i> Quay lại
                                    </a>
                                </form>



                                <!-- Modal Từ chối bài viết -->
                                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('moderator.articles.reject', $article) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Từ chối bài viết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="rejection_reason">Lý do từ chối</label>
                                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- Thông tin cơ bản -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Thông tin cơ bản</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <h4><i class="mdi mdi-title"></i> {{ $article->title }}</h4>
                                            <p class="text-muted"><i class="mdi mdi-link-variant"></i> {{ $article->slug }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <h5>Nội dung tóm tắt:</h5>
                                            <p>{{ $article->preview_content }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Nội dung chi tiết:</h5>
                                            <div class="bg-light p-3 rounded">
                                                {!! $article->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin bổ sung -->
                        <div class="col-md-4">
                            @if ($article->thumbnail_url)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Ảnh đại diện</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Tiêu chí xuất bản -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tiêu chí xuất bản</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="verification-criteria">
                                        <div class="criteria-content">
                                            <ul class="criteria-list" id="criteria-list">
                                                <li class="criteria-item failed" id="criteria-title" data-target="title">
                                                    <div class="criteria-icon failed">✗</div>
                                                    <div class="criteria-text criteria-tooltip">
                                                        Tiêu đề từ 50-60 ký tự <span id="current-title-length">(0 ký tự)</span>
                                                        <span class="tooltip-text">Tiêu đề trong khoảng 50-60 ký tự sẽ hiển thị đầy đủ trên Google và tối ưu cho SEO</span>
                                                    </div>
                                                </li>
                                                <li class="criteria-item failed" id="criteria-category" data-target="parent_category">
                                                    <div class="criteria-icon failed">✗</div>
                                                    <div class="criteria-text criteria-tooltip">
                                                        Chọn danh mục chính và phụ
                                                        <span class="tooltip-text">Bắt buộc chọn cả danh mục chính và danh mục phụ phù hợp với nội dung bài viết</span>
                                                    </div>
                                                </li>
                                                <li class="criteria-item failed" id="criteria-tags" data-target="tags">
                                                    <div class="criteria-icon failed">✗</div>
                                                    <div class="criteria-text criteria-tooltip">
                                                        Chọn 2-5 thẻ tag liên quan <span id="current-tag-count">(0 thẻ)</span>
                                                        <span class="tooltip-text">Thẻ tag phù hợp giúp phân loại bài viết và tăng khả năng xuất hiện trong tìm kiếm</span>
                                                    </div>
                                                </li>
                                                <li class="criteria-item failed" id="criteria-thumbnail" data-target="thumbnail_url">
                                                    <div class="criteria-icon failed">✗</div>
                                                    <div class="criteria-text criteria-tooltip">
                                                        Ảnh đại diện chất lượng cao
                                                        <span class="tooltip-text">Ảnh đại diện rõ nét, liên quan đến nội dung bài viết và không vi phạm bản quyền</span>
                                                    </div>
                                                </li>
                                                <li class="criteria-item failed" id="criteria-content" data-target="content">
                                                    <div class="criteria-icon failed">✗</div>
                                                    <div class="criteria-text criteria-tooltip">
                                                        Nội dung từ 800-1500 từ <span id="current-word-count">(0 từ)</span>
                                                        <span class="tooltip-text">Nội dung đủ dài để cung cấp thông tin đầy đủ nhưng không quá dài gây mất tập trung</span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="criteria-progress mt-3">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" id="criteria-progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-center mt-1">
                                                    <small id="criteria-count">0/5 tiêu chí đạt</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Thông tin khác</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-account"></i> Tác giả:</span>
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $article->author->username ?? 'Không có' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-folder"></i> Danh mục chính:</span>
                                            <span
                                                class="badge bg-info rounded-pill">{{ $article->category->name ?? 'Không có' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-folder-outline"></i> Danh mục phụ:</span>
                                            <span
                                                class="badge bg-secondary rounded-pill">{{ $article->subcategory->name ?? 'Không có' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-eye"></i> Lượt xem:</span>
                                            <span class="badge bg-secondary rounded-pill">{{ $article->views }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-check-circle"></i> Trạng thái:</span>
                                            <span
                                                class="badge bg-{{ $article->status == 'published' ? 'success' : 'warning' }} rounded-pill">
                                                {{ ucfirst($article->status) }}
                                            </span>
                                        </li>
                                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-alert-circle"></i> Nội dung nhạy cảm:</span>
                                            <span class="badge bg-{{ $article->contains_sensitive_content ? 'danger' : 'success' }} rounded-pill">
                                                {{ $article->contains_sensitive_content ? 'Có' : 'Không' }}
                                            </span>
                                        </li> --}}
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="mdi mdi-account-check"></i> Được duyệt bởi:</span>
                                            <span
                                                class="badge bg-dark rounded-pill">{{ $article->approver->username ?? 'Chưa được duyệt' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span><i class="mdi mdi-tag-multiple"></i> Thẻ:</span>
                                            <div class="mt-2">
                                                @if ($article->tags->isNotEmpty())
                                                    @foreach ($article->tags as $tag)
                                                        <span class="badge bg-primary m-1">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có thẻ</span>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Từ chối bài viết -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Từ chối bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('moderator.articles.reject', $article) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Lý do từ chối</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Styles for verification criteria */
    .verification-criteria {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }

    .verification-criteria-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .criteria-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .criteria-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e9ecef;
    }

    .criteria-item:last-child {
        border-bottom: none;
    }

    .criteria-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .criteria-icon.passed {
        background-color: #28a745;
        color: white;
    }

    .criteria-icon.failed {
        background-color: #dc3545;
        color: white;
    }

    .criteria-text {
        flex: 1;
        font-size: 14px;
        position: relative;
    }

    .criteria-tooltip {
        cursor: help;
    }

    .criteria-tooltip .tooltip-text {
        visibility: hidden;
        width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 8px;
        position: absolute;
        z-index: 1000;
        bottom: 125%;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 12px;
    }

    .criteria-tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Progress bar styles */
    .criteria-progress {
        margin-top: 15px;
    }

    .criteria-progress .progress {
        height: 10px;
        border-radius: 5px;
        background-color: #e9ecef;
        margin-bottom: 5px;
        overflow: hidden;
    }

    .criteria-progress .progress-bar {
        height: 100%;
        transition: width 0.3s ease;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra và cập nhật tiêu chí
        updateCriteria();
    });

    function updateCriteria() {
        // Kiểm tra tiêu đề
        const title = "{{ $article->title }}";
        const titleLength = title.length;
        const titleCriteria = document.getElementById('criteria-title');
        const titleLengthSpan = document.getElementById('current-title-length');
        if (titleLengthSpan) {
            titleLengthSpan.textContent = `(${titleLength} ký tự)`;
            if (titleLength >= 50 && titleLength <= 60) {
                titleLengthSpan.style.color = '#28a745';
                updateCriteriaStatus(titleCriteria, true);
            } else {
                titleLengthSpan.style.color = '#dc3545';
                updateCriteriaStatus(titleCriteria, false);
            }
        }

        // Kiểm tra danh mục
        const categoryCriteria = document.getElementById('criteria-category');
        const parentCategoryBadge = document.querySelector('.list-group-item:nth-child(2) .badge.bg-info');
        const childCategoryBadge = document.querySelector('.list-group-item:nth-child(3) .badge.bg-secondary');

        const hasParentCategory = parentCategoryBadge && parentCategoryBadge.textContent !== 'Không có';
        const hasChildCategory = childCategoryBadge && childCategoryBadge.textContent !== 'Không có';

        if (categoryCriteria) {
            // Chỉ hiển thị tích xanh khi cả hai danh mục đều có
            updateCriteriaStatus(categoryCriteria, hasParentCategory && hasChildCategory);
        }

        // Kiểm tra tags
        const tagCriteria = document.getElementById('criteria-tags');
        const tagCountSpan = document.getElementById('current-tag-count');
        const tagCount = {{ $article->tags->count() }};
        if (tagCountSpan) {
            tagCountSpan.textContent = `(${tagCount} thẻ)`;
            if (tagCount >= 2 && tagCount <= 5) {
                tagCountSpan.style.color = '#28a745';
                updateCriteriaStatus(tagCriteria, true);
            } else {
                tagCountSpan.style.color = '#dc3545';
                updateCriteriaStatus(tagCriteria, false);
            }
        }

        // Kiểm tra ảnh đại diện
        const thumbnailCriteria = document.getElementById('criteria-thumbnail');
        const hasThumbnail = {{ $article->thumbnail_url ? 'true' : 'false' }};
        if (thumbnailCriteria) {
            updateCriteriaStatus(thumbnailCriteria, hasThumbnail);
        }

        // Kiểm tra nội dung
        const contentCriteria = document.getElementById('criteria-content');
        const wordCountSpan = document.getElementById('current-word-count');
        const content = document.querySelector('.bg-light.p-3.rounded').innerText;
        const wordCount = countWords(content);
        if (wordCountSpan) {
            wordCountSpan.textContent = `(${wordCount} từ)`;
            if (wordCount >= 800 && wordCount <= 1500) {
                wordCountSpan.style.color = '#28a745';
                updateCriteriaStatus(contentCriteria, true);
            } else {
                wordCountSpan.style.color = '#dc3545';
                updateCriteriaStatus(contentCriteria, false);
            }
        }

        // Cập nhật thanh tiến trình
        updateProgressBar();
    }

    function updateCriteriaStatus(criteriaElement, isPassed) {
        if (!criteriaElement) return;

        const iconElement = criteriaElement.querySelector('.criteria-icon');
        if (isPassed) {
            criteriaElement.classList.remove('failed');
            criteriaElement.classList.add('passed');
            iconElement.textContent = '✓';
            iconElement.classList.remove('failed');
            iconElement.classList.add('passed');
        } else {
            criteriaElement.classList.remove('passed');
            criteriaElement.classList.add('failed');
            iconElement.textContent = '✗';
            iconElement.classList.remove('passed');
            iconElement.classList.add('failed');
        }
    }

    function updateProgressBar() {
        const criteriaCount = document.querySelectorAll('.criteria-item.passed').length;
        const progressBar = document.getElementById('criteria-progress-bar');
        const criteriaCountSpan = document.getElementById('criteria-count');

        if (progressBar) {
            progressBar.style.width = `${criteriaCount * 20}%`;
        }

        if (criteriaCountSpan) {
            criteriaCountSpan.textContent = `${criteriaCount}/5 tiêu chí đạt`;
        }
    }

    function countWords(str) {
        // Đếm số từ trong văn bản tiếng Việt
        return str.trim().split(/\s+/).length;
    }
</script>
@endsection