@extends('author.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h2>Thống kê Dashboard</h2>

    <div class="charts-container">
        <div class="chart-container">
            <h3>Lượt xem bài viết</h3>
            <canvas id="viewsChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Bài viết theo trạng thái</h3>
            <canvas id="postsStatusChart"></canvas>
        </div>
    </div>

    <script>
        // Dữ liệu lượt xem bài viết
        const viewsData = {
            labels: {!! json_encode(array_keys($viewsData->toArray())) !!},
            datasets: [
                {
                    label: 'Lượt xem bài viết',
                    data: {!! json_encode(array_values($viewsData->toArray())) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    fill: true,
                },
            ],
        };

        // Dữ liệu trạng thái bài viết
        const statusData = {
            labels: ['Draft', 'Pending', 'Published'],
            datasets: [
                {
                    data: [
                        {{ $articleStats['draft'] }},
                        {{ $articleStats['pending'] }},
                        {{ $articleStats['published'] }}
                    ],
                    backgroundColor: ['#ffc107', '#17a2b8', '#28a745'],
                },
            ],
        };

        // Khởi tạo biểu đồ lượt xem bài viết
        new Chart(document.getElementById('viewsChart'), {
            type: 'line',
            data: viewsData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true },
                },
            },
        });

        // Khởi tạo biểu đồ trạng thái bài viết
        new Chart(document.getElementById('postsStatusChart'), {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1,
                plugins: {
                    legend: { position: 'bottom' },
                },
            },
        });
    </script>

@endsection
