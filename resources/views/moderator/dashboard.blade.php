@extends('moderator.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
                <!-- Tổng quan bài viết -->
                <div class="row mt-20">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <i class="fa fa-file-text-o fs-40 text-primary"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-0">{{ $articleStatsSummary->approved + $articleStatsSummary->rejected }}</h4>
                                                <p class="text-fade mb-0">Tổng số bài viết đã duyệt</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <i class="fa fa-check-circle fs-40 text-success"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-0">{{ $articleStatsSummary->approved }}</h4>
                                                <p class="text-fade mb-0">Bài viết đã duyệt</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <i class="fa fa-times-circle fs-40 text-danger"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-0">{{ $articleStatsSummary->rejected }}</h4>
                                                <p class="text-fade mb-0">Bài viết bị từ chối</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Bộ lọc thống kê -->
            <div class="box mt-20">
                <div class="box-header with-border">
                    <h4 class="box-title">Bộ lọc thống kê</h4>
                </div>
                <div class="box-body">
                    <form id="filterForm">
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
                                <button type="button" class="btn btn-secondary w-100 py-2 mt-20" id="resetFilter">Đặt lại</button>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="mt-20 mx-30 h-50">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="box-title">Thống kê bài viết đã duyệt</h4>

                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="articleStatsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="mt-20 mx-30 h-50">
                            <h4 class="box-title">Thống kê tương tác bài viết đã duyệt</h4>
                        </div>
                        <div class="box-body">
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="interactionStatsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="box">
                        <div class="box-header">
                            <h4>Thống kê Tag Theo Số Lượng Bài Viết Đã Duyệt</h4>
                        </div>
                        <div class="box-body">
                            <div id="chartLegend" style="text-align: center; margin-bottom: 10px; font-weight: bold;">
                                Số lượng Tag Theo Số Lượng Bài Viết Đã Xuất Bản
                            </div>
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
    <script id="tagsStatsData" type="application/json">
        @json($tags)
    </script>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ thống kê bài viết và tương tác
        document.addEventListener('DOMContentLoaded', function () {
            let articleChart = null;
            let interactionChart = null;

            function renderArticleChart(stats) {
                const labels = stats.map(stat => stat.date);
                const approvedData = stats.map(stat => stat.approved);
                const rejectedData = stats.map(stat => stat.rejected);

                if (articleChart) {
                    articleChart.destroy();
                }

                const ctx = document.getElementById('articleStatsChart').getContext('2d');
                articleChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Bài viết đã duyệt',
                                data: approvedData,
                                borderColor: '#4CAF50',
                                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                                fill: true,
                                borderWidth: 1,
                                pointRadius: 1,
                                pointHoverRadius: 3,
                                tension: 0.3
                            },
                            {
                                label: 'Bài viết bị từ chối',
                                data: rejectedData,
                                borderColor: '#F44336',
                                backgroundColor: 'rgba(244, 67, 54, 0.1)',
                                fill: true,
                                borderWidth: 1,
                                pointRadius: 1,
                                pointHoverRadius: 3,
                                tension: 0.3
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: false,
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0,
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: true,
                                    drawBorder: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    },
                });
            }

            function renderInteractionChart(stats) {
                const labels = stats.map(stat => stat.date);
                const viewsData = stats.map(stat => stat.views);
                const commentsData = stats.map(stat => stat.comments);
                const likesData = stats.map(stat => stat.likes);

                if (interactionChart) {
                    interactionChart.destroy();
                }

                const ctx = document.getElementById('interactionStatsChart').getContext('2d');
                interactionChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Lượt xem',
                                data: viewsData,
                                borderColor: '#3498DB',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                fill: true,
                                borderWidth: 1,
                                pointRadius: 1,
                                pointHoverRadius: 3,
                                tension: 0.3
                            },
                            {
                                label: 'Bình luận',
                                data: commentsData,
                                borderColor: '#F1C40F',
                                backgroundColor: 'rgba(241, 196, 15, 0.1)',
                                fill: true,
                                borderWidth: 1,
                                pointRadius: 1,
                                pointHoverRadius: 3,
                                tension: 0.3
                            },
                            {
                                label: 'Lượt thích',
                                data: likesData,
                                borderColor: '#E74C3C',
                                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                                fill: true,
                                borderWidth: 1,
                                pointRadius: 1,
                                pointHoverRadius: 3,
                                tension: 0.3
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: false,
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0,
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: true,
                                    drawBorder: true,
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    },
                });
            }

            function fetchFilteredData() {
                const dateFrom = document.getElementById('date_from').value;
                const dateTo = document.getElementById('date_to').value;
                const viewType = document.getElementById('view_type').value;

                fetch(`{{ route('moderator.dashboard') }}?date_from=${dateFrom}&date_to=${dateTo}&view_type=${viewType}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.timeBasedArticleStats) {
                            renderArticleChart(data.timeBasedArticleStats);
                        }
                        if (data.timeBasedInteractionStats) {
                            renderInteractionChart(data.timeBasedInteractionStats);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

            // Tự động cập nhật khi thay đổi
            document.getElementById('date_from').addEventListener('change', fetchFilteredData);
            document.getElementById('date_to').addEventListener('change', fetchFilteredData);
            document.getElementById('view_type').addEventListener('change', fetchFilteredData);

            // Reset form
            document.getElementById('resetFilter').addEventListener('click', function () {
                document.getElementById('date_from').value = '';
                document.getElementById('date_to').value = '';
                document.getElementById('view_type').value = 'daily';
                fetchFilteredData();
            });

            // Render initial charts
            const initialArticleStats = JSON.parse(document.getElementById('articleStatsData').textContent);
            const initialInteractionStats = JSON.parse(document.getElementById('interactionStatsData').textContent);

            if (initialArticleStats) {
                renderArticleChart(initialArticleStats);
            }
            if (initialInteractionStats) {
                renderInteractionChart(initialInteractionStats);
            }
        });

        // Biểu đồ thống kê thẻ tag
        document.addEventListener('DOMContentLoaded', function () {
            let tagsChart = null;

            function renderTagsChart(tags) {
                const labels = tags.map(tag => tag.name.length > 15 ? tag.name.substring(0, 15) + '...' : tag.name);
                const data = tags.map(tag => tag.articles_count);

                if (tagsChart) {
                    tagsChart.destroy();
                }

                const ctx = document.getElementById('tagsChart').getContext('2d');
                const canvasWidth = Math.max(1000, labels.length * 50);
                const canvasHeight = 300;
                const canvasElement = document.getElementById('tagsChart');
                canvasElement.style.width = `${canvasWidth}px`;
                canvasElement.style.height = `${canvasHeight}px`;

                tagsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số lượng bài viết',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }],
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 0,
                                    callback: function(value) {
                                        return this.getLabelForValue(value);
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                grid: {
                                    drawBorder: true
                                }
                            }
                        }
                    }
                });
            }

            // Render initial tags chart
            renderTagsChart(JSON.parse(document.getElementById('tagsStatsData').textContent));
        });
    </script>
@endsection
