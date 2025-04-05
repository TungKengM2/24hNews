@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            {{-- <section class="content">
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
            </section> --}}

            <section class="content mt-4">
                <h1>Biểu Đồ Thống Kê</h1>
                <div class="row">
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="article_type">Thống Kê Bài Viết :</label>
                                <select class="form-select w-auto" id="article_type" name="type" onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="articleStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}">
                                <label for="user_type">Thống Kê Người Dùng :</label>
                                <select class="form-select w-auto" id="user_type" name="type" onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="userStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('admin.dashboard') }}" class="form-inline">
                                <label for="interaction_type">Thống Kê Tương Tác :</label>
                                <select class="form-select w-auto" id="interaction_type" name="type" onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>
                            <canvas id="interactionStatsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // tổng quan
        document.addEventListener('DOMContentLoaded', function() {
            // Biểu đồ thống kê bài viết
            const articleStatsChart = @json($articleStatsChart);
            const articleType = "{{ $type }}";
            const articleLabels = [];
            const articleData = [];

            if (articleType === 'daily') {
                articleLabels.push(...articleStatsChart.map(stat => stat.date));
            } else if (articleType === 'monthly') {
                articleLabels.push(...articleStatsChart.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                articleLabels.push(...articleStatsChart.map(stat => stat.year));
            }

            articleData.push(...articleStatsChart.map(stat => Math.floor(stat.count)));

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
                        fill: true,
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

            // Biểu đồ thống kê người dùng
            const userStats = @json($userStats);
            const authorStats = @json($authorStats);
            const moderatorStats = @json($moderatorStats);
            const userType = "{{ $type }}";

            const userLabels = new Set();
            const userData = [];
            const authorData = [];
            const moderatorData = [];

            if (userType === 'daily') {
                userStats.forEach(stat => userLabels.add(stat.date));
                authorStats.forEach(stat => userLabels.add(stat.date));
                moderatorStats.forEach(stat => userLabels.add(stat.date));
            } else if (userType === 'monthly') {
                userStats.forEach(stat => userLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                authorStats.forEach(stat => userLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                moderatorStats.forEach(stat => userLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                userStats.forEach(stat => userLabels.add(stat.year));
                authorStats.forEach(stat => userLabels.add(stat.year));
                moderatorStats.forEach(stat => userLabels.add(stat.year));
            }

            const sortedUserLabels = Array.from(userLabels).sort();

            userData.push(...sortedUserLabels.map(label => {
                const found = userStats.find(stat => (userType === 'daily' ? stat.date : (userType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            }));

            authorData.push(...sortedUserLabels.map(label => {
                const found = authorStats.find(stat => (userType === 'daily' ? stat.date : (userType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            }));

            moderatorData.push(...sortedUserLabels.map(label => {
                const found = moderatorStats.find(stat => (userType === 'daily' ? stat.date : (userType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            }));

            const userCtx = document.getElementById('userStatsChart').getContext('2d');
            new Chart(userCtx, {
                type: 'line',
                data: {
                    labels: sortedUserLabels,
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

            // Biểu đồ thống kê tương tác
            const likeStats = @json($likeStats);
            const commentStats = @json($commentStats);
            const viewsStats = @json($viewsStats);
            const interactionType = "{{ $type }}";

            const interactionLabels = new Set();

            if (interactionType === 'daily') {
                likeStats.forEach(stat => interactionLabels.add(stat.date));
                commentStats.forEach(stat => interactionLabels.add(stat.date));
                viewsStats.forEach(stat => interactionLabels.add(stat.date));
            } else if (interactionType === 'monthly') {
                likeStats.forEach(stat => interactionLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                commentStats.forEach(stat => interactionLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                viewsStats.forEach(stat => interactionLabels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                likeStats.forEach(stat => interactionLabels.add(stat.year));
                commentStats.forEach(stat => interactionLabels.add(stat.year));
                viewsStats.forEach(stat => interactionLabels.add(stat.year));
            }

            const sortedInteractionLabels = Array.from(interactionLabels).sort();

            const roundedLikeData = sortedInteractionLabels.map(label => {
                const found = likeStats.find(stat => (interactionType === 'daily' ? stat.date : (interactionType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const roundedCommentData = sortedInteractionLabels.map(label => {
                const found = commentStats.find(stat => (interactionType === 'daily' ? stat.date : (interactionType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const roundedViewsData = sortedInteractionLabels.map(label => {
                const found = viewsStats.find(stat => (interactionType === 'daily' ? stat.date : (interactionType === 'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const interactionCtx = document.getElementById('interactionStatsChart').getContext('2d');
            new Chart(interactionCtx, {
                type: 'line',
                data: {
                    labels: sortedInteractionLabels,
                    datasets: [
                        {
                            label: 'Số lượt thích',
                            data: roundedLikeData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            borderWidth: 1
                        },
                        {
                            label: 'Số bình luận',
                            data: roundedCommentData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            borderWidth: 1
                        },
                        {
                            label: 'Số lượt xem',
                            data: roundedViewsData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            borderWidth: 1
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
    </script>
@endsection