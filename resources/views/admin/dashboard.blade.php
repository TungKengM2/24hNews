@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            {{-- <section class="content">
                <!-- Thống kê bài viết -->
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
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bản nháp</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đang lưu nháp</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['draft'] ?? 0 }}</h3>
                                    <div class="text-secondary">
                                        <i class="fa fa-pencil-square-o fa-2x"></i>
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
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info-light mt-10">
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
                                            <div class="icon bg-primary-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <i class="fa fa-eye fs-30"></i>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalViews ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Lượt xem</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div class="icon bg-success-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Chat"><span class="path1"></span><span class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalComments ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Bình luận</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div class="icon bg-warning-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Heart"><span class="path1"></span><span class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalLikes ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Lượt thích</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
            <!-- /.content -->
            <h2>Thống kê bài viết</h2>
            <button onclick="fetchArticleData('daily')">Thống kê theo ngày</button>
            <button onclick="fetchArticleData('monthly')">Thống kê theo tháng</button>
            <canvas id="articleChart"></canvas>

            <h2>Thống kê người dùng</h2>
            <canvas id="userChart"></canvas>
        </div>
    </div>
<<<<<<< HEAD
=======

    @push('scripts')
    {{-- <script>
        $(document).ready(function() {
            // Lấy dữ liệu thống kê người dùng
            $.ajax({
                url: '{{ route("admin.userStats") }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Tính tổng số người dùng từ dữ liệu trả về
                    var totalUsers = 0;

                    data.forEach(function(item) {
                        var users = parseInt(item.users) || 0;
                        var authors = parseInt(item.authors) || 0;
                        var moderators = parseInt(item.moderators) || 0;

                        totalUsers += users + authors + moderators;
                    });

                    $('#total-users').text(totalUsers);
                }
            });
        });
    </script> --}}
    <script>
         async function fetchArticleData(type) {
            const response = await fetch(`/articles/stats?type=${type}`);
            const data = await response.json();

            const labels = data.map(item => item.date || `${item.month}/${item.year}`);
            const counts = data.map(item => item.count);

            renderChart('articleChart', labels, counts, `Số bài viết (${type})`);
        }

        async function fetchUserData() {
            const response = await fetch(`/users/stats`);
            const data = await response.json();

            const labels = data.map(item => item.period);
            const users = data.map(item => item.users);
            const authors = data.map(item => item.authors);
            const moderators = data.map(item => item.moderators);

            renderMultiChart('userChart', labels, users, authors, moderators);
        }

        function renderChart(canvasId, labels, counts, labelText) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            if (window[canvasId]) {
                window[canvasId].destroy();
            }

            window[canvasId] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: labelText,
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function renderMultiChart(canvasId, labels, users, authors, moderators) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            if (window[canvasId]) {
                window[canvasId].destroy();
            }

            window[canvasId] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Người dùng',
                            data: users,
                            borderColor: 'blue',
                            fill: false
                        },
                        {
                            label: 'Tác giả',
                            data: authors,
                            borderColor: 'green',
                            fill: false
                        },
                        {
                            label: 'Moderator',
                            data: moderators,
                            borderColor: 'red',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Gọi API khi trang load
        fetchArticleData('daily');
        fetchUserData();
    </script>
    @endpush
>>>>>>> b91bd48 (upload thống kê user bài viết của kdv)
@endsection
