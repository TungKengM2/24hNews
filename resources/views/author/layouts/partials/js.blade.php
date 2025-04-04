<!-- Vendor JS -->
<script src="/admin/main/js/vendors.min.js"></script>
<script src="/admin/main/js/pages/chat-popup.js"></script>
<script src="/admin/main/../assets/icons/feather-icons/feather.min.js"></script>

<script src="/admin/main/../assets/vendor_components/apexcharts-bundle/irregular-data-series.js"></script>
<script src="/admin/main/../assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
<script src="/admin/main/../assets/vendor_components/zingchart_branded_version/zingchart.min.js"></script>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- CrmX Admin App -->
<script src="/admin/main/js/template.js"></script>
<script src="/admin/main/js/demo.js"></script>
<script src="/admin/main/js/pages/dashboard.js"></script>
<script src="/admin/assets/vendor_components/select2/dist/js/select2.full.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- thống kê -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Article statistics chart
        const articleStats = @json($timeBasedArticleStats ?? []);
        const type = "{{ $type ?? 'daily' }}";
        
        let articleLabels = [];
        let articleData = [];

        if (type === 'daily') {
            articleLabels = articleStats.map(stat => stat.date || '');
            articleData = articleStats.map(stat => stat.count || 0);
        } else if (type === 'monthly') {
            articleLabels = articleStats.map(stat => `${stat.year || ''}-${String(stat.month || '').padStart(2, '0')}`);
            articleData = articleStats.map(stat => stat.count || 0);
        } else { // yearly
            articleLabels = articleStats.map(stat => stat.year || '');
            articleData = articleStats.map(stat => stat.count || 0);
        }

        // Check if we have data to display
        if (articleLabels.length > 0) {
            document.getElementById('noArticleDataMessage').style.display = 'none';
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
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            document.getElementById('articleStatsChart').style.display = 'none';
            document.getElementById('noArticleDataMessage').style.display = 'block';
        }

        // Interaction statistics chart
        const interactionStats = @json($timeBasedInteractionStats ?? []);
        const interactionType = "{{ $interactionType ?? 'daily' }}";
        
        // Debug: Log the raw interaction stats to console
        console.log('Raw interaction stats:', interactionStats);
        
        let interactionLabels = [];
        let viewsData = [];
        let likesData = [];
        let commentsData = [];

        if (interactionType === 'daily') {
            interactionLabels = interactionStats.map(stat => stat.date || '');
            viewsData = interactionStats.map(stat => stat.views || 0);
            likesData = interactionStats.map(stat => stat.likes || 0);
            commentsData = interactionStats.map(stat => stat.comments || 0);
        } else if (interactionType === 'monthly') {
            interactionLabels = interactionStats.map(stat => `${stat.year || ''}-${String(stat.month || '').padStart(2, '0')}`);
            viewsData = interactionStats.map(stat => stat.views || 0);
            likesData = interactionStats.map(stat => stat.likes || 0);
            commentsData = interactionStats.map(stat => stat.comments || 0);
        } else { // yearly
            interactionLabels = interactionStats.map(stat => stat.year || '');
            viewsData = interactionStats.map(stat => stat.views || 0);
            likesData = interactionStats.map(stat => stat.likes || 0);
            commentsData = interactionStats.map(stat => stat.comments || 0);
        }
        
        // Debug: Log the processed data
        console.log('Processed chart data:', {
            labels: interactionLabels,
            views: viewsData,
            likes: likesData,
            comments: commentsData
        });

        // Check if we have data to display
        if (interactionLabels.length > 0) {
            document.getElementById('noInteractionDataMessage').style.display = 'none';
            const interactionCtx = document.getElementById('interactionStatsChart').getContext('2d');
            
            // Create the chart with all three datasets
            new Chart(interactionCtx, {
                type: 'line',
                data: {
                    labels: interactionLabels,
                    datasets: [
                        {
                            label: 'Lượt xem',
                            data: viewsData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Lượt thích',
                            data: likesData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Bình luận',
                            data: commentsData,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderWidth: 3, // Make the line thicker
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Lượt xem'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            title: {
                                display: true,
                                text: 'Lượt thích & Bình luận'
                            }
                        }
                    }
                }
            });
        } else {
            document.getElementById('interactionStatsChart').style.display = 'none';
            document.getElementById('noInteractionDataMessage').style.display = 'block';
        }
        
        // Store the data in global variables for the debug function
        window.chartData = {
            labels: interactionLabels,
            views: viewsData,
            likes: likesData,
            comments: commentsData
        };
    });
</script>

<script>
    function toggleDebugData() {
        const content = document.getElementById('debugDataContent');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            document.getElementById('debugJson').textContent = JSON.stringify(window.chartData, null, 2);
        } else {
            content.style.display = 'none';
        }
    }
</script>


<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
    
    @include('shared.tiny')
