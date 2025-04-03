@extends('moderator.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row">
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('moderator.dashboard') }}">
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
                            <form method="GET" action="{{ route('moderator.dashboard') }}">
                                <label for="type">Thống Kê Người Dùng</label>
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
                            <form method="GET" action="{{ route('moderator.dashboard') }}">
                                <label for="type">Thống Kê Lượt Thích </label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>

                            <canvas id="likeStats" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('moderator.dashboard') }}">
                                <label for="type">Thống Kê Bình Luận </label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>

                            <canvas id="commentStats" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // bài viết
        document.addEventListener('DOMContentLoaded', function() {
            const articleStats = @json($articleStats);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...articleStats.map(stat => stat.date));
            } else if (type === 'monthly') {
                labels.push(...articleStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                labels.push(...articleStats.map(stat => stat.year));
            }

            const roundedData = articleStats.map(stat => Math.floor(stat.count));

            const ctx = document.getElementById('statsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số bài viết',
                        data: roundedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
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

        // người dùng
        document.addEventListener('DOMContentLoaded', function() {
            const userStats = @json($userStats);
            const authorStats = @json($authorStats);
            const type = "{{ $type }}";

            let labels = [];
            let userData = [];
            let authorData = [];

            if (type === 'daily') {
                labels = userStats.map(stat => stat.date);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
            } else if (type === 'monthly') {
                labels = userStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
            } else { // yearly
                labels = userStats.map(stat => stat.year);
                userData = userStats.map(stat => Math.floor(stat.count));
                authorData = authorStats.map(stat => Math.floor(stat.count));
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
                            borderColor: 'rgba(192, 75, 75, 1)',
                            backgroundColor: 'rgba(192, 75, 75, 0.2)',
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
        // lượt thích
        document.addEventListener('DOMContentLoaded', function() {
            const likeStats = @json($likeStats);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...likeStats.map(stat => stat.date));
            } else if (type === 'monthly') {
                labels.push(...likeStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                labels.push(...likeStats.map(stat => stat.year));
            }

            const roundedData = likeStats.map(stat => Math.floor(stat.count));

            const ctx = document.getElementById('likeStats').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượt thích',
                        data: roundedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
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

        // bình luận
        document.addEventListener('DOMContentLoaded', function() {
            const commentStats = @json($commentStats);
            const type = "{{ $type }}";
            let labels = [];
            let data = [];

            if (type === 'daily') {
                labels = commentStats.map(stat => stat.date);
                data = commentStats.map(stat => stat.count);
            } else if (type === 'monthly') {
                labels = commentStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                data = commentStats.map(stat => stat.count);
            } else { // yearly
                labels = commentStats.map(stat => stat.year);
                data = commentStats.map(stat => stat.count);
            }

            const ctx = document.getElementById('commentStats').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số bình luận',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
    </script>
@endsection
