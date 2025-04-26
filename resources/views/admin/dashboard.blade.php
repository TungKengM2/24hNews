@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="row mt-20">
               <h3>Tổng Quan Bài Viết</h3>
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
                            <div class="mt-40 d-flex justify-content-between align-items-center">
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
                            <div class="mt-40 d-flex justify-content-between align-items-center">
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
                            <div class="mt-40 d-flex justify-content-between align-items-center">
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
            // Dữ liệu bài viết
            const articleStatsData = JSON.parse(document.getElementById('articleStatsData').textContent);
            const articleLabels = articleStatsData.map(stat => stat.date);
            const publishedData = articleStatsData.map(stat => stat.published);
            const pendingData = articleStatsData.map(stat => stat.pending);
            const rejectedData = articleStatsData.map(stat => stat.rejected);
            const draftData = articleStatsData.map(stat => stat.draft);
            const archivedData = articleStatsData.map(stat => stat.archived);

            // Biểu đồ bài viết
            const articleStatsChartCtx = document.getElementById('articleStatsChart').getContext('2d');
            new Chart(articleStatsChartCtx, {
                type: 'line',
                data: {
                    labels: articleLabels,
                    datasets: [
                        {
                            label: 'Đã xuất bản',
                            data: publishedData,
                            borderColor: '#4CAF50', // Màu xanh lá cây đậm
                            backgroundColor: 'rgba(76, 175, 80, 0.2)', // Màu nền mờ
                            borderWidth: 1, // Đường mỏng hơn
                            tension: 0.3, // Đường cong mượt hơn
                            fill: true
                        },
                        {
                            label: 'Đang chờ',
                            data: pendingData,
                            borderColor: '#FFC107', // Màu vàng
                            backgroundColor: 'rgba(255, 193, 7, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Bị từ chối',
                            data: rejectedData,
                            borderColor: '#F44336', // Màu đỏ
                            backgroundColor: 'rgba(244, 67, 54, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Lưu nháp',
                            data: draftData,
                            borderColor: '#2196F3', // Màu xanh dương
                            backgroundColor: 'rgba(33, 150, 243, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Đã lưu trữ',
                            data: archivedData,
                            borderColor: '#9C27B0', // Màu tím
                            backgroundColor: 'rgba(156, 39, 176, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, callback: value => Number.isInteger(value) ? value : null }
                        }
                    }
                },
            });

            // Dữ liệu tương tác
            const interactionStatsData = JSON.parse(document.getElementById('interactionStatsData').textContent);
            const commentsStatsData = JSON.parse(document.getElementById('commentsStatsData').textContent);
            const likesStatsData = JSON.parse(document.getElementById('likesStatsData').textContent);

            const interactionLabels = interactionStatsData.map(stat => stat.date);
            const viewsData = interactionStatsData.map(stat => stat.views);
            const commentsData = commentsStatsData.map(stat => stat.comments);
            const likesData = likesStatsData.map(stat => stat.likes);

            // Biểu đồ tương tác
            const interactionStatsChartCtx = document.getElementById('interactionStatsChart').getContext('2d');
            new Chart(interactionStatsChartCtx, {
                type: 'line',
                data: {
                    labels: interactionLabels,
                    datasets: [
                        {
                            label: 'Lượt xem',
                            data: viewsData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Bình luận',
                            data: commentsData,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Lượt thích',
                            data: likesData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1,
                            tension: 0.3,
                            fill: true
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, callback: value => Number.isInteger(value) ? value : null }
                        }
                    }
                },
            });
        });
        // select theo
        document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('filterForm');
        const dateFromInput = document.getElementById('date_from');
        const dateToInput = document.getElementById('date_to');

        // Nút Đặt lại
        document.getElementById('resetFilter').addEventListener('click', function () {
            dateFromInput.value = '';
            dateToInput.value = '';
            filterForm.submit();
        });

        // Nút Ngày trước
        document.getElementById('yesterdayFilter').addEventListener('click', function () {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);

            const formattedDate = yesterday.toISOString().split('T')[0];
            dateFromInput.value = formattedDate;
            dateToInput.value = formattedDate;
            filterForm.submit();
        });

        // Nút Tuần trước
        document.getElementById('lastWeekFilter').addEventListener('click', function () {
            const today = new Date();
            const lastWeekStart = new Date();
            lastWeekStart.setDate(today.getDate() - 7);
            const lastWeekEnd = new Date();
            lastWeekEnd.setDate(today.getDate() - 1);

            dateFromInput.value = lastWeekStart.toISOString().split('T')[0];
            dateToInput.value = lastWeekEnd.toISOString().split('T')[0];
            filterForm.submit();
        });

        // Nút Tháng trước
        document.getElementById('lastMonthFilter').addEventListener('click', function () {
            const today = new Date();
            const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);

            dateFromInput.value = lastMonthStart.toISOString().split('T')[0];
            dateToInput.value = lastMonthEnd.toISOString().split('T')[0];
            filterForm.submit();
        });
    });
    </script>
    <script>
         document.addEventListener('DOMContentLoaded', function () {
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
            filterForm.submit();
        });

        // Xử lý thay đổi dropdown "Hiển thị theo"
        viewTypeSelect.addEventListener('change', function () {
            filterForm.submit();
        });
    });
    </script>
    <script>
          // tag   // Biểu đồ thống kê tag theo số lượng bài viết
          document.addEventListener('DOMContentLoaded', function() {
            const tagsData = @json($tags);

            // Lấy tên tag và số lượng bài viết
            const labels = tagsData.map(tag => tag.name); // Tên tag
            const data = tagsData.map(tag => Math.floor(tag
                .published_articles_count)); // Số lượng bài viết (chỉ lấy số nguyên)

            // Cấu hình chiều rộng canvas dựa trên số lượng tag
            const tagsPerView = 10; // Số tag hiển thị mỗi lần
            const canvasWidth = Math.max(400, labels.length * 40); // Tính chiều rộng canvas (40px mỗi tag)
            const canvas = document.getElementById('tagsChart');
            canvas.width = canvasWidth; // Thiết lập chiều rộng của canvas
            canvas.height = 200; // Chiều cao cố định

            // Lấy vùng canvas
            const ctx = canvas.getContext('2d');

            // Tạo biểu đồ
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Biểu Đồ Thống Kê Tag Theo Số Lượng Bài Viết Đã Xuất Bản',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false, // Không responsive để kiểm soát kích thước
                    maintainAspectRatio: false, // Không giữ tỉ lệ
                    plugins: {
                        legend: {
                            display: false // Tắt chú thích mặc định
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false // Hiển thị tất cả nhãn
                            }
                        },
                        y: {
                            beginAtZero: true, // Bắt đầu từ 0 trên trục Y,
                            ticks: {
                                stepSize: 1 // Bước nhảy của trục Y
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection