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
        const viewsData = {
            labels: ['01/02', '02/02', '03/02', '04/02', '05/02', '06/02', '07/02'],
            datasets: [
                {
                    label: 'Lượt xem bài viết',
                    data: [120, 150, 180, 220, 250, 230, 300],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    fill: true,
                },
            ],
        };

        const statusData = {
            labels: ['Draft', 'Pending', 'Published'],
            datasets: [
                {
                    data: [10, 5, 20],
                    backgroundColor: ['#ffc107', '#17a2b8', '#28a745'],
                },
            ],
        };

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
