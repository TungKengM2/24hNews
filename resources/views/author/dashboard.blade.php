@extends('author.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <script>
                        // Hiển thị thông báo SweetAlert2 trực tiếp
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                @if (isset($isBanned) && $isBanned)
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Tài khoản bị tạm khóa!',
                                        html: '<div class="text-start"><p><strong>Tài khoản của bạn đã bị tạm khóa đến {{ $banEndTime }}.</strong></p>' +
                                            '<p>Bạn không thể thực hiện các hành động liên quan đến bài viết trong thời gian này.</p>' +
                                            '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                                        confirmButtonText: 'Tôi đã hiểu',
                                        confirmButtonColor: '#3085d6'
                                    });
                                @endif
                            }, 300);
                        });
                    </script>
                    <div class="row">
                        <h3>Tổng Quan Bài Viết </h3>
                        <!-- Tổng số bài viết -->
                        <div class="col-xl-2 col-md-4 col-12  ">
                            <div class="box ">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Tổng bài viết</h5>

                                        </div>
                                    </div>
                                    <div class="mt-40 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['total'] }}</h3>
                                        <div class="text-primary">
                                            <i class="fa fa-file-text fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- Published -->
                         <div class="col-xl-2 col-md-4 col-12 ">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Bài viết đã xuất bản</h5>

                                        </div>
                                    </div>
                                    <div class="mt-20 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['published'] }}</h3>
                                        <div class="text-success">
                                            <i class="fa fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Pending -->
                        <div class="col-xl-2 col-md-4 col-12 ">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Bài viết đang chờ</h5>

                                        </div>
                                    </div>
                                    <div class="mt-20 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['pending'] }}</h3>
                                        <div class="text-warning">
                                            <i class="fa fa-hourglass-half fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Rejected -->
                        <div class="col-xl-2 col-md-4 col-12 ">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Bài viết bị từ chối</h5>

                                        </div>
                                    </div>
                                    <div class="mt-20 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['reject'] }}</h3>
                                        <div class="text-danger">
                                            <i class="fa fa-times-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Archived -->
                        <div class="col-xl-2 col-md-4 col-12 ">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Bài viết đã lưu trữ</h5>

                                        </div>
                                    </div>
                                    <div class="mt-20 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['archived'] }}</h3>
                                        <div class="text-secondary">
                                            <i class="fa fa-archive fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Draft -->
                        <div class="col-xl-2 col-md-4 col-12 ">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-15">
                                            <h5 class="mb-0">Bài viết lưu nháp</h5>

                                        </div>
                                    </div>
                                    <div class="mt-20 d-flex justify-content-between align-items-center">
                                        <h3 class="fw-600">{{ $articleStats['draft'] }}</h3>
                                        <div class="text-info">
                                            <i class="fa fa-pencil-square fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Bộ lọc thống kê -->
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Bộ lọc thống kê</h4>
                                <small class="text-muted ms-2">(Dữ liệu tự động cập nhật khi thay đổi)</small>
                            </div>
                            <div class="box-body">
                                <form id="filterForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="date_from">Từ ngày</label>
                                            <input type="date" class="form-control" id="date_from" name="date_from"
                                                value="{{ request('date_from') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="date_to">Đến ngày</label>
                                            <input type="date" class="form-control" id="date_to" name="date_to"
                                                value="{{ request('date_to') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="view_type">Hiển thị theo</label>
                                            <select class="form-control" id="view_type" name="view_type">
                                                <option value="daily" {{ request('view_type', 'daily') === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                                <option value="monthly" {{ request('view_type') === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                                <option value="yearly" {{ request('view_type') === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-secondary me-2" id="resetFilter">Đặt lại</button>
                                                <div class="spinner-border text-primary ms-2" role="status" id="filterSpinner" style="display: none;">
                                                    <span class="visually-hidden">Đang tải...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hiển thị ngày bắt đầu và ngày kết thúc -->
                <div class="row" id="dateRangeInfo" style="{{ (request('date_from') || request('date_to')) ? '' : 'display: none;' }}">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <p class="mb-0 text-primary">
                                <strong class="text-primary">Khoảng thời gian:</strong>
                                <span id="dateFromDisplay">{{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') : 'Không có' }}</span>
                                đến
                                <span id="dateToDisplay">{{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') : 'Không có' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Time-based statistics section -->
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê bài viết</h4>
                            </div>
                            <div class="box-body">
                                <div style="height: 300px;">
                                    <canvas id="articleStatsChart" width="400" height="300"></canvas>
                                    <div id="noArticleDataMessage" class="text-center p-4" style="display: none;">
                                        <p>Không có dữ liệu để hiển thị</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê tương tác</h4>
                            </div>
                            <div class="box-body">
                                <div style="height: 300px;">
                                    <canvas id="interactionStatsChart" width="400" height="300"></canvas>
                                    <div id="noInteractionDataMessage" class="text-center p-4" style="display: none;">
                                        <p>Không có dữ liệu để hiển thị</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Người theo dõi</h4>
                            </div>
                            <div class="box-body text-center">
                                <div class="mb-20">
                                    <div class="icon bg-info-light rounded-circle w-80 h-80 text-center mx-auto l-h-100">
                                        <span class="fs-40 icon-User"><span class="path1"></span><span
                                                class="path2"></span></span>
                                    </div>
                                </div>
                                <h1 class="countnm fs-50">{{ $followerCount }}</h1>
                                <p class="mb-0 text-fade">Người theo dõi</p>
                                <a href="{{ route('author.followers') }}" class="btn btn-info-light mt-10">
                                    <i class="fa fa-users"></i> Xem danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê lượt tương tác tổng</h4>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div
                                                class="icon bg-primary-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span
                                                    class="icon bg-primary-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                    <i class="fa fa-eye fs-30"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalViews }}</h3>
                                        <p class="mb-0 text-fade">Lượt xem</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div
                                                class="icon bg-success-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Chat"><span class="path1"></span><span
                                                        class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalComments }}</h3>
                                        <p class="mb-0 text-fade">Bình luận</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div
                                                class="icon bg-warning-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Heart"><span class="path1"></span><span
                                                        class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalLikes }}</h3>
                                        <p class="mb-0 text-fade">Lượt thích</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Bài viết gần đây</h4>
                            </div>
                            <div class="box-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày tạo</th>
                                                <th>Lượt xem</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentArticles as $article)
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('author.articles.edit', $article->article_id) }}">
                                                            {{ Str::limit($article->title, 50) }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if ($article->status == 'published')
                                                            <span class="badge badge-success"><i
                                                                    class="fa fa-check-circle"></i> Đã xuất bản</span>
                                                        @elseif($article->status == 'pending')
                                                            <span class="badge badge-warning"><i
                                                                    class="fa fa-hourglass-half"></i> Chờ duyệt</span>
                                                        @elseif($article->status == 'draft')
                                                            <span class="badge badge-secondary"><i
                                                                    class="fa fa-pencil-square-o"></i> Bản nháp</span>
                                                        @else
                                                            <span class="badge badge-info">{{ $article->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $article->created_at->format('d/m/Y') }}</td>
                                                    <td>{{ $article->views ?? 0 }}</td>
                                                    <td>
                                                        <a href="{{ route('author.articles.edit', $article->article_id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @if ($article->status == 'published')
                                                            <a href="{{ route('author.articles.show', $article) }}"
                                                                class="btn btn-info btn-sm" title="Xem chi tiết">
                                                                <i class="si-eye si"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Không có bài viết nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Biến toàn cục để lưu trữ các biểu đồ
            let articleChart = null;
            let interactionChart = null;

            // Khởi tạo biểu đồ ban đầu
            initCharts();

            function initCharts() {
                // Article statistics chart
                const articleStats = @json($timeBasedArticleStats ?? []);
                const type = "{{ $type ?? 'daily' }}";

                renderArticleChart(articleStats, type);

                // Interaction statistics chart
                const interactionStats = @json($timeBasedInteractionStats ?? []);
                const interactionType = "{{ $interactionType ?? 'daily' }}";

                renderInteractionChart(interactionStats, interactionType);

                // Store the data in global variables for the debug function
                updateChartData();
            }

            // Hàm render biểu đồ bài viết
            function renderArticleChart(articleStats, type) {
                let articleLabels = [];
                let articleData = [];

                if (type === 'daily') {
                    articleLabels = articleStats.map(stat => stat.date || '');
                    articleData = articleStats.map(stat => stat.count || 0);
                } else if (type === 'monthly') {
                    articleLabels = articleStats.map(stat =>
                        `${stat.year || ''}-${String(stat.month || '').padStart(2, '0')}`);
                    articleData = articleStats.map(stat => stat.count || 0);
                } else { // yearly
                    articleLabels = articleStats.map(stat => stat.year || '');
                    articleData = articleStats.map(stat => stat.count || 0);
                }

                // Check if we have data to display
                if (articleLabels.length > 0) {
                    document.getElementById('noArticleDataMessage').style.display = 'none';
                    document.getElementById('articleStatsChart').style.display = 'block';

                    const articleCtx = document.getElementById('articleStatsChart').getContext('2d');

                    // Nếu biểu đồ đã tồn tại, hủy nó trước khi tạo mới
                    if (articleChart) {
                        articleChart.destroy();
                    }

                    articleChart = new Chart(articleCtx, {
                        type: 'line',
                        data: {
                            labels: articleLabels,
                            datasets: [{
                                label: 'Số bài viết',
                                data: articleData,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('articleStatsChart').style.display = 'none';
                    document.getElementById('noArticleDataMessage').style.display = 'block';
                }
            }

            // Hàm render biểu đồ tương tác
            function renderInteractionChart(interactionStats, type) {
                let interactionLabels = [];
                let viewsData = [];
                let likesData = [];
                let commentsData = [];

                if (type === 'daily') {
                    interactionLabels = interactionStats.map(stat => stat.date || '');
                    viewsData = interactionStats.map(stat => stat.views || 0);
                    likesData = interactionStats.map(stat => stat.likes || 0);
                    commentsData = interactionStats.map(stat => stat.comments || 0);
                } else if (type === 'monthly') {
                    interactionLabels = interactionStats.map(stat =>
                        `${stat.year || ''}-${String(stat.month || '').padStart(2, '0')}`);
                    viewsData = interactionStats.map(stat => stat.views || 0);
                    likesData = interactionStats.map(stat => stat.likes || 0);
                    commentsData = interactionStats.map(stat => stat.comments || 0);
                } else { // yearly
                    interactionLabels = interactionStats.map(stat => stat.year || '');
                    viewsData = interactionStats.map(stat => stat.views || 0);
                    likesData = interactionStats.map(stat => stat.likes || 0);
                    commentsData = interactionStats.map(stat => stat.comments || 0);
                }

                // Check if we have data to display
                if (interactionLabels.length > 0) {
                    document.getElementById('noInteractionDataMessage').style.display = 'none';
                    document.getElementById('interactionStatsChart').style.display = 'block';

                    const interactionCtx = document.getElementById('interactionStatsChart').getContext('2d');

                    // Nếu biểu đồ đã tồn tại, hủy nó trước khi tạo mới
                    if (interactionChart) {
                        interactionChart.destroy();
                    }

                    // Create the chart with all three datasets
                    interactionChart = new Chart(interactionCtx, {
                        type: 'line',
                        data: {
                            labels: interactionLabels,
                            datasets: [{
                                    label: 'Lượt xem',
                                    data: viewsData,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Lượt thích',
                                    data: likesData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    yAxisID: 'y1'
                                },
                                {
                                    label: 'Bình luận',
                                    data: commentsData,
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                    borderWidth: 3, // Make the line thicker
                                    tension: 0.3,
                                    fill: true,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Lượt xem'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        min: 1
                                    }
                                },
                                y1: {
                                    beginAtZero: true,
                                    position: 'right',
                                    grid: {
                                        drawOnChartArea: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Lượt thích & Bình luận'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        min: 1
                                    }
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('interactionStatsChart').style.display = 'none';
                    document.getElementById('noInteractionDataMessage').style.display = 'block';
                }
            }

            // Cập nhật dữ liệu biểu đồ cho debug
            function updateChartData() {
                if (interactionChart) {
                    window.chartData = {
                        labels: interactionChart.data.labels,
                        views: interactionChart.data.datasets[0].data,
                        likes: interactionChart.data.datasets[1].data,
                        comments: interactionChart.data.datasets[2].data
                    };
                }
            }

            // Hàm gọi AJAX để lấy dữ liệu mới
            function fetchFilteredData() {
                // Hiển thị spinner
                document.getElementById('filterSpinner').style.display = 'inline-block';

                // Lấy giá trị từ form
                const dateFrom = document.getElementById('date_from').value;
                const dateTo = document.getElementById('date_to').value;
                const viewType = document.getElementById('view_type').value;

                // Gọi API để lấy dữ liệu
                fetch(`{{ route('author.dashboard.filter') }}?date_from=${dateFrom}&date_to=${dateTo}&view_type=${viewType}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật biểu đồ với dữ liệu mới
                            renderArticleChart(data.timeBasedArticleStats, data.type);
                            renderInteractionChart(data.timeBasedInteractionStats, data.type);

                            // Cập nhật thông tin khoảng thời gian
                            updateDateRangeInfo(data.dateFrom, data.dateTo);

                            // Cập nhật dữ liệu debug
                            updateChartData();
                        } else {
                            console.error('Lỗi khi lấy dữ liệu:', data);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Đã xảy ra lỗi khi lấy dữ liệu. Vui lòng thử lại sau.',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi gọi API:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã xảy ra lỗi khi kết nối đến máy chủ. Vui lòng thử lại sau.',
                            confirmButtonText: 'Đóng'
                        });
                    })
                    .finally(() => {
                        // Ẩn spinner
                        document.getElementById('filterSpinner').style.display = 'none';
                    });
            }

            // Hàm cập nhật thông tin khoảng thời gian
            function updateDateRangeInfo(dateFrom, dateTo) {
                const dateRangeInfo = document.getElementById('dateRangeInfo');
                const dateFromDisplay = document.getElementById('dateFromDisplay');
                const dateToDisplay = document.getElementById('dateToDisplay');

                if (dateFrom || dateTo) {
                    dateRangeInfo.style.display = '';

                    if (dateFrom) {
                        const fromDate = new Date(dateFrom);
                        dateFromDisplay.textContent = fromDate.toLocaleDateString('vi-VN');
                    } else {
                        dateFromDisplay.textContent = 'Không có';
                    }

                    if (dateTo) {
                        const toDate = new Date(dateTo);
                        dateToDisplay.textContent = toDate.toLocaleDateString('vi-VN');
                    } else {
                        dateToDisplay.textContent = 'Không có';
                    }
                } else {
                    dateRangeInfo.style.display = 'none';
                }
            }

            // Xử lý bộ lọc
            const filterForm = document.getElementById('filterForm');
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');
            const viewTypeSelect = document.getElementById('view_type');
            const resetButton = document.getElementById('resetFilter');

            // Xử lý nút Đặt lại
            resetButton.addEventListener('click', function () {
                dateFromInput.value = '';
                dateToInput.value = '';
                viewTypeSelect.value = 'daily'; // Mặc định về "Theo ngày"
                fetchFilteredData();
            });

            // Xử lý thay đổi loại hiển thị (ngày, tháng, năm)
            viewTypeSelect.addEventListener('change', function() {
                const today = new Date();
                const selectedValue = this.value;

                // Tự động điều chỉnh khoảng thời gian dựa trên loại hiển thị
                if (selectedValue === 'daily') {
                    // Nếu chọn theo ngày, chỉ hiển thị ngày hôm nay
                    dateFromInput.value = today.toISOString().split('T')[0];
                    dateToInput.value = today.toISOString().split('T')[0];
                } else if (selectedValue === 'monthly') {
                    // Nếu chọn theo tháng, hiển thị 30 ngày gần nhất
                    const startDate = new Date();
                    startDate.setDate(today.getDate() - 30);
                    dateFromInput.value = startDate.toISOString().split('T')[0];
                    dateToInput.value = today.toISOString().split('T')[0];
                } else if (selectedValue === 'yearly') {
                    // Nếu chọn theo năm, hiển thị 12 tháng gần nhất
                    const startDate = new Date();
                    startDate.setMonth(today.getMonth() - 12);
                    dateFromInput.value = startDate.toISOString().split('T')[0];
                    dateToInput.value = today.toISOString().split('T')[0];
                }

                // Tự động cập nhật dữ liệu khi thay đổi loại hiển thị
                fetchFilteredData();
            });

            // Thêm sự kiện lắng nghe cho thay đổi ngày bắt đầu
            dateFromInput.addEventListener('change', function() {
                fetchFilteredData();
            });

            // Thêm sự kiện lắng nghe cho thay đổi ngày kết thúc
            dateToInput.addEventListener('change', function() {
                fetchFilteredData();
            });



            // Xử lý thông báo
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Tôi đã hiểu'
                });
            @endif

            @if (session('violation_error'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Cảnh báo vi phạm!',
                    text: '{{ session('violation_error') }}',
                    confirmButtonText: 'Tôi đã hiểu'
                });
            @endif

            // Hiển thị thông báo SweetAlert2 khi trang được tải
            setTimeout(function() {
                // Kiểm tra số vi phạm của author
                @if (auth()->user()->violation_count > 5)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cảnh báo vi phạm!',
                        html: '<div class="text-start"><p><strong>Tài khoản của bạn hiện có {{ auth()->user()->violation_count }} vi phạm.</strong></p>' +
                            '<p>Bạn không thể thực hiện các hành động liên quan đến bài viết cho đến khi số vi phạm giảm xuống dưới 5.</p>' +
                            '<p>Vui lòng liên hệ quản trị viên để được hỗ trợ.</p></div>',
                        confirmButtonText: 'Tôi đã hiểu',
                        confirmButtonColor: '#3085d6'
                    });
                @endif
            }, 500);

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endsection
