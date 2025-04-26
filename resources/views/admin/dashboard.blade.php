@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <h1>Tổng Quan Bài Viết </h1>
                    <!-- Tổng số bài viết -->
                    <div class="col-xl-3 col-md-6 col-12  ">
                        <div class="box ">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Tổng bài viết</h5>
                                        <p class="mb-0 text-fade fs-12">Tất cả trạng thái</p>

                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['total'] }}</h3>
                                    <div class="text-primary">
                                        <i class="fa fa-file-text fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Published -->
                    <div class="col-xl-3 col-md-6 col-12 ">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bài viết đã xuất bản</h5>
                                        <p class="mb-0 text-fade fs-12">Trạng thái: Đã xuất bản</p>

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
                    <!-- Archived -->
                    {{-- <div class="col-xl-3 col-md-6 col-12 ">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bài viết đã lưu trữ</h5>
                                        <p class="mb-0 text-fade fs-12">Trạng thái: Đã lưu trữ</p>

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
                    </div> --}}

                    <!-- Pending -->
                    <div class="col-xl-3 col-md-6 col-12 ">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bài viết đang chờ</h5>
                                        <p class="mb-0 text-fade fs-12">Trạng thái: Đang chờ</p>

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
                    <div class="col-xl-3 col-md-6 col-12 ">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bài viết bị từ chối</h5>
                                        <p class="mb-0 text-fade fs-12">Trạng thái: Bị từ chối</p>

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

                    {{-- <!-- Draft -->
                    <div class="col-xl-3 col-md-6 col-12 ">
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
                    </div> --}}

                </div>
                <!-- Thống kê người dùng -->
                <div class="row">
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
                </div>

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
                    <!-- Người theo dõi dat them -->
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

                <div class="col-12">
                    <!-- Bộ lọc -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Bộ lọc</h4>
                        </div>
                        <div class="box-body" id="filterCollapse">
                            <form action="{{ route('admin.dashboard') }}" method="GET">
                                <div class="row">
                                    <!-- Từ ngày -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_from">Từ ngày</label>
                                            <input type="date" class="form-control" id="date_from" name="date_from"
                                                value="{{ request('date_from') }}">
                                        </div>
                                    </div>
                                    <!-- Đến ngày -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_to">Đến ngày</label>
                                            <input type="date" class="form-control" id="date_to" name="date_to"
                                                value="{{ request('date_to') }}">
                                        </div>
                                    </div>
                                    <!-- Nút hành động -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i> Tìm kiếm
                                                </button>
                                                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">
                                                    <i class="fa fa-refresh"></i> Đặt lại
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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

                <!-- Thống kê -->
                <div class="row mt-2">
                    <!-- Biểu đồ thống kê bài viết -->
                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê bài viết</h4>
                            </div>
                            <div class="box-body">
                                <canvas id="articleStatsChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ thống kê tương tác -->
                    <div class="col-12 col-xl-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê tương tác</h4>
                            </div>
                            <div class="box-body">
                                <canvas id="interactionStatsChart" width="400" height="200"></canvas>
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
                    {{-- <div class="col-6">
                    <div class="box">
                        <div style="width: 80%; margin: auto;">
                            <h1>Thống kê số lượng bài viết theo Tag</h1>
                            <canvas id="tagsChart" width="800" height="400"></canvas>
                            <p id="noTagDataMessage" style="color: red; display: none;">Không có dữ liệu để hiển thị.</p>
                        </div>
                    </div>
                   </div> --}}
                </div>



            </section>
        </div>
    </div>


    <script id="articleStatsData" type="application/json">
        @json($articleStats)
    </script>
    <script id="interactionStatsData" type="application/json">
        {
            "totalViews": {{ $totalViews }},
            "totalComments": {{ $totalComments }},
            "totalLikes": {{ $totalLikes }},
            "totalFollowers": {{ $totalFollowers }}
        }
    </script>

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @endsection
    <script>
        //
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra và xử lý bộ lọc ngày
            const filterForm = document.querySelector('form[action*="admin.dashboard"]');
            if (filterForm) {
                filterForm.addEventListener('submit', function(event) {
                    const dateFrom = document.getElementById('date_from').value;
                    const dateTo = document.getElementById('date_to').value;

                    if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
                        event.preventDefault();
                        alert('Ngày bắt đầu không được lớn hơn ngày kết thúc.');
                    }
                });
            }

            // Dữ liệu thống kê bài viết
            const articleStats = JSON.parse(document.getElementById('articleStatsData').textContent);
            const articleStatsLabels = ['Tổng bài viết', 'Lưu trữ', 'Chờ duyệt', 'Xuất bản', 'Từ chối', 'Nháp'];
            const articleStatsData = [
                articleStats.total,
                articleStats.archived,
                articleStats.pending,
                articleStats.published,
                articleStats.reject,
                articleStats.draft
            ];

            // Biểu đồ Thống kê bài viết (Line Chart)
            const articleStatsChartCtx = document.getElementById('articleStatsChart').getContext('2d');
            new Chart(articleStatsChartCtx, {
                type: 'line', // Biểu đồ dạng đường
                data: {
                    labels: articleStatsLabels,
                    datasets: [{
                        label: 'Thống kê bài viết',
                        data: articleStatsData,
                        borderColor: '#4caf50',
                        backgroundColor: 'rgba(76, 175, 80, 0.2)', // Màu nền mờ
                        borderWidth: 2,
                        fill: true, // Tô màu dưới đường
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Bắt đầu trục y từ 0
                        },
                    },
                },
            });

            // Dữ liệu thống kê tương tác
            const interactionStats = JSON.parse(document.getElementById('interactionStatsData').textContent);
            const interactionStatsLabels = ['Lượt xem', 'Bình luận', 'Lượt thích', 'Người theo dõi'];
            const interactionStatsData = [
                interactionStats.totalViews,
                interactionStats.totalComments,
                interactionStats.totalLikes,
                interactionStats.totalFollowers
            ];

            // Biểu đồ Thống kê tương tác (Line Chart)
            const interactionStatsChartCtx = document.getElementById('interactionStatsChart').getContext('2d');
            new Chart(interactionStatsChartCtx, {
                type: 'line', // Biểu đồ dạng đường
                data: {
                    labels: interactionStatsLabels,
                    datasets: [{
                        label: 'Thống kê tương tác',
                        data: interactionStatsData,
                        borderColor: '#03a9f4',
                        backgroundColor: 'rgba(3, 169, 244, 0.2)', // Màu nền mờ
                        borderWidth: 2,
                        fill: true, // Tô màu dưới đường
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Bắt đầu trục y từ 0
                        },
                    },
                },
            });
        });
        // Thống kê số lượng bài viết theo Tag
        // Biểu đồ thống kê tag theo số lượng bài viết
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
