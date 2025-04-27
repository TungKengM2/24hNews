@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="row mt-20">
               <h3>Tổng Quan Bài Viết</h3>
                <!-- Tổng số bài viết -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Tổng bài viết</h5>

                                </div>
                            </div>
                            <div class="mt-40 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['total'] }}</h3>
                                <div class="text-primary">
                                    <i class="fa fa-file-text fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Archived -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Bài viết đã lưu trữ</h5>

                                </div>
                            </div>
                            <div class="mt-40 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['archived'] }}</h3>
                                <div class="text-secondary">
                                    <i class="fa fa-archive fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Bài viết đang chờ</h5>

                                </div>
                            </div>
                            <div class="mt-40 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['pending'] }}</h3>
                                <div class="text-warning">
                                    <i class="fa fa-hourglass-half fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Bài viết đã xuất bản</h5>

                                </div>
                            </div>
                            <div class="mt-20 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['published'] }}</h3>
                                <div class="text-success">
                                    <i class="fa fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Bài viết bị từ chối</h5>

                                </div>
                            </div>
                            <div class="mt-40 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['rejected'] }}</h3>
                                <div class="text-danger">
                                    <i class="fa fa-times-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft -->
                <div class="col-xl-2 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Bài viết lưu nháp</h5>

                                </div>
                            </div>
                            <div class="mt-40 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $articleStatsSummary['draft'] }}</h3>
                                <div class="text-info">
                                    <i class="fa fa-pencil-square fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Thống kê người dùng -->
            <div class="row">
                <!-- Tổng số người dùng -->
                <h3>Tổng Quan Người Dùng</h3>
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
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-15">
                                    <h5 class="mb-0">Người theo dõi </h5>
                                    <p class="mb-0 text-fade fs-12">Tổng số người đang theo dõi </p>
                                </div>
                            </div>
                            <div class="mt-20 d-flex justify-content-between align-items-center">
                                <h3 class="fw-600">{{ $totalFollowers }}</h3>
                                <div class="text-info">
                                    <a href="{{ route('admin.followers') }}" class="btn btn-primary">
                                        <i class="fa fa-eye "></i> Xem danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Bộ lọc -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Bộ lọc</h4>
                </div>
                <div class="box-body">
                    <form action="{{ route('admin.dashboard') }}" method="GET" id="filterForm">
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
                                    <button type="submit" class="btn btn-primary mr-2">Lọc</button>
                                    <button type="button" class="btn btn-secondary" id="resetFilter">Đặt lại</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hiển thị ngày bắt đầu và ngày kết thúc -->
            @if(request('date_from') || request('date_to'))
                <div class="col-12 mt-3">
                    <div class="alert alert-info">
                        <p>
                            <strong>Ngày bắt đầu:</strong> {{ request('date_from') ? request('date_from') : 'Không có' }}
                        </p>
                        <p>
                            <strong>Ngày kết thúc:</strong> {{ request('date_to') ? request('date_to') : 'Không có' }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Biểu đồ -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Thống kê bài viết</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="articleStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Thống kê tương tác</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="interactionStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-6">
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
                </div>
            </div>
        </div>
    </div>

    <script id="articleStatsData" type="application/json">
        @json($timeBasedArticleStats)
    </script>
    <script id="interactionStatsData" type="application/json">
        @json($timeBasedInteractionStats)
    </script>
    <script id="commentsStatsData" type="application/json">
        @json($timeBasedCommentsStats)
    </script>
    <script id="likesStatsData" type="application/json">
        @json($timeBasedLikesStats)
    </script>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    let articleChart = null;
    let interactionChart = null;
    let tagsChart = null;

    function renderArticleChart(stats) {
        const labels = stats.map(stat => stat.date);
        const publishedData = stats.map(stat => stat.published);
        const pendingData = stats.map(stat => stat.pending);
        const rejectedData = stats.map(stat => stat.rejected);
        const draftData = stats.map(stat => stat.draft);
        const archivedData = stats.map(stat => stat.archived);

        if (articleChart) {
            articleChart.destroy();
        }

        const ctx = document.getElementById('articleStatsChart').getContext('2d');
        articleChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Đã xuất bản', data: publishedData, borderColor: '#4CAF50', backgroundColor: 'rgba(76, 175, 80, 0.2)', fill: true },
                    { label: 'Đang chờ', data: pendingData, borderColor: '#FFC107', backgroundColor: 'rgba(255, 193, 7, 0.2)', fill: true },
                    { label: 'Bị từ chối', data: rejectedData, borderColor: '#F44336', backgroundColor: 'rgba(244, 67, 54, 0.2)', fill: true },
                    { label: 'Lưu nháp', data: draftData, borderColor: '#2196F3', backgroundColor: 'rgba(33, 150, 243, 0.2)', fill: true },
                    { label: 'Đã lưu trữ', data: archivedData, borderColor: '#9C27B0', backgroundColor: 'rgba(156, 39, 176, 0.2)', fill: true },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true, position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });
    }

    function renderInteractionChart(stats) {
        const labels = stats.map(stat => stat.date);
        const viewsData = stats.map(stat => stat.views);
        const commentsData = stats.map(stat => stat.comments);
        const likesData = stats.map(stat => stat.likes);

        if (interactionChart) {
            interactionChart.destroy();
        }

        const ctx = document.getElementById('interactionStatsChart').getContext('2d');
        interactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Lượt xem', data: viewsData, borderColor: '#36A2EB', backgroundColor: 'rgba(54, 162, 235, 0.2)', fill: true },
                    { label: 'Bình luận', data: commentsData, borderColor: '#FFCE56', backgroundColor: 'rgba(255, 206, 86, 0.2)', fill: true },
                    { label: 'Lượt thích', data: likesData, borderColor: '#4BC0C0', backgroundColor: 'rgba(75, 192, 192, 0.2)', fill: true },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true, position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });
    }

    function renderTagsChart(tags) {
        const labels = tags.map(tag => tag.name.length > 15 ? tag.name.substring(0, 15) + '...' : tag.name); // Truncate long tag names
        const data = tags.map(tag => tag.published_articles_count);

        if (tagsChart) {
            tagsChart.destroy();
        }

        const ctx = document.getElementById('tagsChart').getContext('2d');
        const canvasWidth = Math.max(1000, labels.length * 50); // Dynamically adjust canvas width based on the number of tags
        const canvasHeight = 300; // Set the height of the chart
        const canvasElement = document.getElementById('tagsChart');
        canvasElement.style.width = `${canvasWidth}px`;
        canvasElement.style.height = `${canvasHeight}px`;

        tagsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượng bài viết',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }],
            },
            options: {
                responsive: false, // Disable responsiveness to allow horizontal scrolling
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide the default legend
                    }
                },
                layout: {
                    padding: {
                        left: 0, // Remove left padding
                        right: 0 // Remove right padding
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false, // Show all labels
                            maxRotation: 45, // Rotate labels for better readability
                            minRotation: 0,
                            callback: function(value) {
                                return this.getLabelForValue(value); // Ensure truncated labels are displayed
                            }
                        },
                        grid: {
                            display: false // Remove grid lines for x-axis
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Set step size for the y-axis
                        },
                        grid: {
                            drawBorder: true // Ensure the y-axis border is visible
                        }
                    }
                }
            }
        });
    }

    function fetchFilteredData() {
        const dateFrom = document.getElementById('date_from').value;
        const dateTo = document.getElementById('date_to').value;
        const viewType = document.getElementById('view_type').value;

        fetch(`{{ route('admin.dashboard') }}?date_from=${dateFrom}&date_to=${dateTo}&view_type=${viewType}`, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then(response => response.json())
            .then(data => {
                renderArticleChart(data.timeBasedArticleStats);
                renderInteractionChart(data.timeBasedInteractionStats);
                renderTagsChart(data.tags);
            })
            .catch(error => console.error('Lỗi:', error));
    }

    document.getElementById('view_type').addEventListener('change', fetchFilteredData);
    document.getElementById('filterForm').addEventListener('submit', function (e) {
        e.preventDefault();
        fetchFilteredData();
    });

    document.getElementById('resetFilter').addEventListener('click', function () {
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        document.getElementById('view_type').value = 'daily';
        fetchFilteredData();
    });

    // Render initial charts
    renderArticleChart(JSON.parse(document.getElementById('articleStatsData').textContent));
    renderInteractionChart(@json($timeBasedInteractionStats));
    renderTagsChart(@json($tags));
});
    </script>
@endsection
