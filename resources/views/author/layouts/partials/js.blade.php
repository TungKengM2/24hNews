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
