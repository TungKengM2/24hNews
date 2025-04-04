@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            {{-- biểu đồ thống kê --}}
            <section class="content mt-" >
                <h1>Biểu Đồ Thống Kê</h1>
                <div class="row">
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="type">Thống Kê Bài Viết :</label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="statsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="type">Thống Kê Người Dùng :</label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="userAuthorStats" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="type">Thống Kê Lượt Thích :</label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="likeStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="type">Thống Kê Bình Luận :</label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="commentStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </section>
            {{-- tổng quan thống kê  --}}
            <section class="content">
                <!-- Thống kê bài viết -->
                <h1>Tổng Quan</h1>
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Tổng bài viết</h5>
                                        <p class="mb-0 text-fade fs-12">Tất cả bài viết</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['total'] ?? 0 }}</h3>
                                    <div class="text-primary">
                                        <i class="fa fa-file-text fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Đã xuất bản</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đã xuất bản</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['published'] ?? 0 }}</h3>
                                    <div class="text-success">
                                        <i class="fa fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Chờ duyệt</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đang chờ duyệt</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['pending'] ?? 0 }}</h3>
                                    <div class="text-warning">
                                        <i class="fa fa-hourglass-half fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê người dùng và tương tác -->
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê người dùng</h4>
                            </div>
                            <div class="box-body text-center">
                                <div class="mb-20">
                                    <div class="icon bg-info-light rounded-circle w-80 h-80 text-center mx-auto l-h-100">
                                        <span class="fs-40 icon-User"><span class="path1"></span><span class="path2"></span></span>
                                    </div>
                                </div>
                                <h1 class="countnm fs-50" id="total-users">0</h1>
                                <p class="mb-0 text-fade">Tổng số người dùng</p>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <h4 class="mb-0" id="total-regular-users">0</h4>
                                        <p class="mb-0 text-fade fs-12">Người dùng</p>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0" id="total-authors">0</h4>
                                        <p class="mb-0 text-fade fs-12">Tác giả</p>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0" id="total-moderators">0</h4>
                                        <p class="mb-0 text-fade fs-12">Kiểm duyệt</p>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0" id="total-admins">0</h4>
                                        <p class="mb-0 text-fade fs-12">Quản trị</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info-light mt-10">
                                    <i class="fa fa-users"></i> Xem danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->

        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Lấy dữ liệu thống kê người dùng
            $.ajax({
                url: '{{ route("admin.userStats") }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Tính tổng số người dùng từ dữ liệu trả về
                    var totalUsers = 0;
                    var totalRegularUsers = 0;
                    var totalAuthors = 0;
                    var totalModerators = 0;
                    var totalAdmins = 0;

                    data.forEach(function(item) {
                        var users = parseInt(item.users) || 0;
                        var authors = parseInt(item.authors) || 0;
                        var moderators = parseInt(item.moderators) || 0;
                        var admins = parseInt(item.admins) || 0;

                        totalRegularUsers += users;
                        totalAuthors += authors;
                        totalModerators += moderators;
                        totalAdmins += admins;
                        totalUsers += users + authors + moderators + admins;
                    });

                    $('#total-regular-users').text(totalRegularUsers);
                    $('#total-authors').text(totalAuthors);
                    $('#total-moderators').text(totalModerators);
                    $('#total-admins').text(totalAdmins);
                    $('#total-users').text(totalUsers);
                }
            });
        });
        // thông kê biểu đồ bài viết
           // bài viết
           document.addEventListener('DOMContentLoaded', function() {
            const articleStatsChart = @json($articleStatsChart);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...articleStatsChart.map(stat => stat.date));
            } else if (type === 'monthly') {
                labels.push(...articleStatsChart.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                labels.push(...articleStatsChart.map(stat => stat.year));
            }

            const roundedData = articleStatsChart.map(stat => Math.floor(stat.count));

            const ctx = document.getElementById('statsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số bài viết',
                        data: roundedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }]
                },
                options: {
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
        });
        // thống kê người dùng
        document.addEventListener('DOMContentLoaded', function() {
            const userStats = @json($userStats);
            const authorStats = @json($authorStats);
            const moderatorStats = @json($moderatorStats);
            const type = "{{ $type }}";

            let labels = [];
            let userData = [];
            let authorData = [];
            let moderatorData = [];

            if (type === 'daily') {
                labels = userStats.map(stat => stat.date);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
                moderatorData = moderatorStats.map(stat => Math.floor(stat.count));
            } else if (type === 'monthly') {
                labels = userStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
                moderatorData = moderatorStats.map(stat => Math.floor(stat.count));
            } else { // yearly
                labels = userStats.map(stat => stat.year);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
                moderatorData = moderatorStats.map(stat => Math.floor(stat.count));
            }

            const ctx = document.getElementById('userAuthorStats').getContext('2d');
            const userAuthorChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Số lượng người dùng',
                            data: userData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Số lượng tác giả',
                            data: authorData,
                            borderColor: 'rgba(255, 229, 0, 1)',
                            backgroundColor: 'rgba(255, 229, 0, 0.2)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Số lượng kiểm duyệt viên',
                            data: moderatorData,
                            borderColor: 'rgba(255, 0, 0, 1)',
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderWidth: 1,
                            fill: true
                        }
                    ]
                },
                options: {
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
        });
        // thống kê lượt thích
        document.addEventListener('DOMContentLoaded', function() {
            const likeStatsChart = @json($likeStatsChart);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...likeStatsChart.map(stat => stat.date));
            } else if (type === 'monthly') {
                labels.push(...likeStatsChart.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                labels.push(...likeStatsChart.map(stat => stat.year));
            }

            const roundedData = likeStatsChart.map(stat => Math.floor(stat.count));

            const ctx = document.getElementById('likeStatsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượt thích ',
                        data: roundedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }]
                },
                options: {
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
        });
        // thống kê bình luận
        document.addEventListener('DOMContentLoaded', function() {
            const commentStatsChart = @json($commentStatsChart);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...commentStatsChart.map(stat => stat.date));
            } else if (type === 'monthly') {
                labels.push(...commentStatsChart.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                labels.push(...commentStatsChart.map(stat => stat.year));
            }

            const roundedData = commentStatsChart.map(stat => Math.floor(stat.count));

            const ctx = document.getElementById('commentStatsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số Bình Luận ',
                        data: roundedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
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
        });
    </script>
    @endpush
@endsection