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
                            <form method="GET" action="{{ route('moderator.dashboard') }}" class="form-inline">
                                <label for="type">Thống Kê Tương Tác :</label>
                                <select class="form-select w-auto" id="type" name="type"
                                    onchange="this.form.submit()">
                                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Theo ngày</option>
                                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Theo năm</option>

                                </select>
                            </form>

                            <canvas id="Tuongtac" width="400" height="214"></canvas>
                        </div>
                    </div>
                    {{-- <div class="col-6">
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

                            <canvas id="userStats" width="400" height="200"></canvas>
                        </div>
                    </div> --}}
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
        });

        // user
        document.addEventListener('DOMContentLoaded', function() {
            const userStats = @json($userStats);
            const type = "{{ $type }}";
            let labels = [];
            let data = [];

            if (type === 'daily') {
                labels = userStats.map(stat => stat.date);
                data = userStats.map(stat => Math.floor(stat.count));
            } else if (type === 'monthly') {
                labels = userStats.map(stat => `${stat.year}-${String(stat.month).padStart(2, '0')}`);
                data = userStats.map(stat => Math.floor(stat.count));
            } else { // yearly
                labels = userStats.map(stat => stat.year);
                data = userStats.map(stat => Math.floor(stat.count));
            }

            const ctx = document.getElementById('userStats').getContext('2d');
            const statsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượng người dùng',
                        data: data,
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
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            }
                        }
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const likeStats = @json($likeStats);
            const commentStats = @json($commentStats);
            const viewsStats = @json($viewsStats);
            const type = "{{ $type }}";

            const labels = new Set();
            const likeData = [];
            const commentData = [];
            const viewsData = [];

            if (type === 'daily') {
                likeStats.forEach(stat => labels.add(stat.date));
                commentStats.forEach(stat => labels.add(stat.date));
                viewsStats.forEach(stat => labels.add(stat.date));
            } else if (type === 'monthly') {
                likeStats.forEach(stat => labels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                commentStats.forEach(stat => labels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
                viewsStats.forEach(stat => labels.add(`${stat.year}-${String(stat.month).padStart(2, '0')}`));
            } else {
                likeStats.forEach(stat => labels.add(stat.year));
                commentStats.forEach(stat => labels.add(stat.year));
                viewsStats.forEach(stat => labels.add(stat.year));
            }

            const sortedLabels = Array.from(labels).sort();

            const roundedLikeData = sortedLabels.map(label => {
                const found = likeStats.find(stat => (type === 'daily' ? stat.date : (type === 'monthly' ?
                    `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const roundedCommentData = sortedLabels.map(label => {
                const found = commentStats.find(stat => (type === 'daily' ? stat.date : (type ===
                    'monthly' ? `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat
                    .year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const roundedViewsData = sortedLabels.map(label => {
                const found = viewsStats.find(stat => (type === 'daily' ? stat.date : (type === 'monthly' ?
                    `${stat.year}-${String(stat.month).padStart(2, '0')}` : stat.year)) === label);
                return found ? Math.floor(found.count) : 0;
            });

            const ctx = document.getElementById('Tuongtac').getContext('2d');
            const Tuongtac = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                            label: 'Số lượt thích',
                            data: roundedLikeData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            borderWidth: 1,
                        },
                        {
                            label: 'Số bình luận',
                            data: roundedCommentData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            borderWidth: 1,
                        },
                        {
                            label: 'Số lượt xem',
                            data: roundedViewsData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
