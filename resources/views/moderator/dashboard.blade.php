@extends('moderator.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                {{-- <div class="row">
                    <h1>Tổng Quan Bài Viết </h1>
                    <!-- Tổng số bài viết -->
                    <div class="col-xl-2 col-md-6 col-12  ">
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
                    <!-- Archived -->
                    <div class="col-xl-2 col-md-6 col-12 ">
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

                    <!-- Pending -->
                    <div class="col-xl-2 col-md-6 col-12 ">
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

                    <!-- Published -->
                    <div class="col-xl-2 col-md-6 col-12 ">
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

                    <!-- Rejected -->
                    <div class="col-xl-2 col-md-6 col-12 ">
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

                    <!-- Draft -->
                    <div class="col-xl-2 col-md-6 col-12 ">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bài viết lưu nháp</h5>

                                    </div>
                                </div>
                                <div class="mt-40 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['draft'] }}</h3>
                                    <div class="text-info">
                                        <i class="fa fa-pencil-square fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}
                <!-- Thống kê người dùng -->
                {{-- <div class="row">
                    <!-- Tổng số người dùng -->
                    <h1>Tổng Quan Người Dùng</h1>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Tổng số người dùng</h5>
                                        <p class="mb-0 text-fade fs-12">Tất cả vai trò</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $userCount['total'] }}</h3>
                                    <div class="text-primary">
                                        <i class="fa fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Người dùng -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Người dùng</h5>
                                        <p class="mb-0 text-fade fs-12">Vai trò: Người dùng</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $userCount['user'] }}</h3>
                                    <div class="text-info">
                                        <i class="fa fa-user fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kiểm duyệt viên -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Kiểm duyệt viên</h5>
                                        <p class="mb-0 text-fade fs-12">Vai trò: Kiểm duyệt viên</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $userCount['moderators'] }}</h3>
                                    <div class="text-success">
                                        <i class="fas fa-user-shield fa-2x"></i> <!-- Cập nhật class -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tác giả -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Tác giả</h5>
                                        <p class="mb-0 text-fade fs-12">Vai trò: Tác giả</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $userCount['authors'] }}</h3>
                                    <div class="text-warning">
                                        <i class="fas fa-user-edit fa-2x"></i> <!-- Cập nhật class -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <h1>Tổng Quan Tương Tác</h1>
                    <!-- Lượt thích -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Lượt thích</h5>
                                        <p class="mb-0 text-fade fs-12">Tổng lượt thích bài viết</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $totalLikes }}</h3>
                                    <div class="text-danger">
                                        <i class="fa fa-thumbs-up fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Lượt xem -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Lượt xem</h5>
                                        <p class="mb-0 text-fade fs-12">Tổng lượt xem bài viết</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $totalViews }}</h3>
                                    <div class="text-success">
                                        <i class="fa fa-eye fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bình luận -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bình luận</h5>
                                        <p class="mb-0 text-fade fs-12">Tất cả bình luận</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $totalComments }}</h3>
                                    <div class="text-warning">
                                        <i class="fa fa-comments fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê bài viết -->
                <div class="row mt-2">
                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border d-flex align-items-center justify-content-between">
                                <h4 class="box-title">Thống kê bài viết</h4>
                                <form method="GET" action="{{ route('moderator.dashboard') }}"
                                    class="d-flex align-items-center">
                                    <label for="article_type" class="me-2">Hiển thị:</label>
                                    <select class="form-select w-auto" id="article_type" name="article_type"
                                        onchange="this.form.submit()">
                                        <option value="daily" {{ ($type ?? 'daily') === 'daily' ? 'selected' : '' }}>Theo
                                            ngày</option>
                                        <option value="monthly" {{ ($type ?? 'daily') === 'monthly' ? 'selected' : '' }}>
                                            Theo tháng</option>
                                        <option value="yearly" {{ ($type ?? 'daily') === 'yearly' ? 'selected' : '' }}>
                                            Theo
                                            năm</option>
                                    </select>
                                </form>
                            </div>
                            <div class="box-body">
                                <canvas id="articleStatsChart" width="400" height="200"></canvas>
                                <div id="noArticleDataMessage" class="text-center p-4" style="display: none;">
                                    <p>Không có dữ liệu để hiển thị</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border d-flex align-items-center justify-content-between">
                                <h4 class="box-title">Thống kê tương tác</h4>
                                <form method="GET" action="{{ route('moderator.dashboard') }}"
                                    class="d-flex align-items-center">
                                    <label for="interaction_type" class="me-2">Hiển thị:</label>
                                    <select class="form-select w-auto" id="interaction_type" name="interaction_type"
                                        onchange="this.form.submit()">
                                        <option value="daily"
                                            {{ ($interactionType ?? 'daily') === 'daily' ? 'selected' : '' }}>Theo ngày
                                        </option>
                                        <option value="monthly"
                                            {{ ($interactionType ?? 'daily') === 'monthly' ? 'selected' : '' }}>Theo tháng
                                        </option>
                                        <option value="yearly"
                                            {{ ($interactionType ?? 'daily') === 'yearly' ? 'selected' : '' }}>Theo năm
                                        </option>
                                    </select>
                                </form>
                            </div>
                            <div class="box-body">
                                <canvas id="interactionStatsChart" width="400" height="200"></canvas>
                                <div id="noInteractionDataMessage" class="text-center p-4" style="display: none;">
                                    <p>Không có dữ liệu để hiển thị</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-6">
                        <div class="box">
                            <div class="box-header">
                                <h4>Thống kê Người Dùng Theo Vai Trò (<span id="selectedType">{{ ucfirst($type) }}</span>)</h4>
                            </div>
                            <div class="box-body">
                                <!-- Dropdown chọn loại thời gian -->
                                <div style="margin-bottom: 15px; text-align: center;">
                                    <label for="timeType">Xem theo: </label>
                                    <select id="timeType" class="form-control" style="display: inline-block; width: auto;">
                                        <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Ngày</option>
                                        <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Tháng</option>
                                        <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Năm</option>
                                    </select>
                                </div>

                                <!-- Chú thích -->
                                <div id="chartLegendUser" style="text-align: center; margin-bottom: 10px; font-weight: bold;">
                                    Số lượng Người Dùng Theo Vai Trò
                                </div>

                                <!-- Biểu đồ -->
                                <div style="overflow-x: auto;" id="chartContainerUser">
                                    <canvas id="usersChart" width="800" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-6">
                        <div class="box">
                            <div class="box-header">
                                <h4>Thống kê Tag Theo Số Lượng Bài Viết</h4>
                            </div>
                            <div class="box-body">
                                <!-- Chú thích cố định -->
                                <div id="chartLegend" style="text-align: center; margin-bottom: 10px; font-weight: bold;">
                                    Số lượng Tag Theo Số Lượng Bài Viết Đã Xuất Bản
                                </div>
                                <!-- Biểu đồ có cuộn ngang -->
                                <div style="overflow-x: auto; white-space: nowrap;" id="chartContainer">
                                    <canvas id="tagsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>



            </section>
        </div>
    </div>



    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Article statistics chart
            const articleStats = @json($timeBasedArticleStats ?? []);
            const type = "{{ $type ?? 'daily' }}";

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

            if (articleLabels.length > 0) {
                document.getElementById('noArticleDataMessage').style.display = 'none';
                const articleCtx = document.getElementById('articleStatsChart').getContext('2d');
                new Chart(articleCtx, {
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

            // Interaction statistics chart
            const interactionStats = @json($timeBasedInteractionStats ?? []);
            const interactionType = "{{ $interactionType ?? 'daily' }}";

            let interactionLabels = [];
            let viewsData = [];
            let likesData = [];
            let commentsData = [];

            if (interactionType === 'daily') {
                interactionLabels = interactionStats.map(stat => stat.date || '');
                viewsData = interactionStats.map(stat => stat.views || 0);
                likesData = interactionStats.map(stat => stat.likes || 0);
                commentsData = interactionStats.map(stat => stat.comments || 0);
            } else if (interactionType === 'monthly') {
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

            if (interactionLabels.length > 0) {
                document.getElementById('noInteractionDataMessage').style.display = 'none';
                const interactionCtx = document.getElementById('interactionStatsChart').getContext('2d');
                new Chart(interactionCtx, {
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
                                fill: true
                            },
                            {
                                label: 'Lượt thích',
                                data: likesData,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Bình luận',
                                data: commentsData,
                                borderColor: 'rgba(255, 206, 86, 1)',
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                borderWidth: 3,
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
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
                document.getElementById('interactionStatsChart').style.display = 'none';
                document.getElementById('noInteractionDataMessage').style.display = 'block';
            }
        });
    </script>
@endsection
