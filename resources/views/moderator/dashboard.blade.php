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
                                <select class="form-select w-auto" id="type" name="type" onchange="this.form.submit()">
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
                                <select class="form-select w-auto" id="type" name="type" onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>
                                </select>
                            </form>

                            <canvas id="userStats" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="box">
                            <form method="GET" action="{{ route('moderator.dashboard') }}">
                                <label for="type">Thống Kê Lượt Thích </label>
                                <select class="form-select w-auto" id="type" name="type" onchange="this.form.submit()">
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
                                <label for="type">Thống Kê Bình Luận  </label>
                                <select class="form-select w-auto" id="type" name="type" onchange="this.form.submit()">
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
        // article
        document.addEventListener('DOMContentLoaded', function () {
            const articleStats = @json($articleStats);
            const userStats = @json($userStats);
            const type = "{{ $type }}";

            const labels = [];
            const data = [];

            if (type === 'daily') {
                labels.push(...articleStats.map(stat => stat.date));
                data.push(...articleStats.map(stat => stat.count));
            } else if (type === 'monthly') {
                labels.push(...articleStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`));
                data.push(...articleStats.map(stat => stat.count));
            } else {
                labels.push(...articleStats.map(stat => stat.year));
                data.push(...articleStats.map(stat => stat.count));
            }

            const ctx = document.getElementById('statsChart').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số bài viết',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
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
        });

        // user
        document.addEventListener('DOMContentLoaded', function () {
            const userStats = @json($userStats);
            const type = "{{ $type }}";
            let labels = [];
            let data = [];

            if (type === 'daily') {
                labels = userStats.map(stat => stat.date);
                data = userStats.map(stat => stat.count);
            } else if (type === 'monthly') {
                labels = userStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                data = userStats.map(stat => stat.count);
            } else { // yearly
                labels = userStats.map(stat => stat.year);
                data = userStats.map(stat => stat.count);
            }

            const ctx = document.getElementById('userStats').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượng bài viết',
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
        });
        // lượt thích
        document.addEventListener('DOMContentLoaded', function () {
            const likeStats = @json($likeStats);
            const type = "{{ $type }}";
            let labels = [];
            let data = [];

            if (type === 'daily') {
                labels = likeStats.map(stat => stat.date);
                data = likeStats.map(stat => stat.count);
            } else if (type === 'monthly') {
                labels = likeStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                data = likeStats.map(stat => stat.count);
            } else { // yearly
                labels = likeStats.map(stat => stat.year);
                data = likeStats.map(stat => stat.count);
            }

            const ctx = document.getElementById('likeStats').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượt thích',
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
        });
        // bình luận
        document.addEventListener('DOMContentLoaded', function () {
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
