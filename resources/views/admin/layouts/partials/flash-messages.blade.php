@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Thành công!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#3085d6'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Lỗi!',
              text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Cảnh báo!',
            text: "{{ session('warning') }}",
            icon: 'warning',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#f8bb86'
        });
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Thông tin!',
            text: "{{ session('info') }}",
            icon: 'info',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#3fc3ee'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Lỗi!',
            html: `<ul style="text-align: left; list-style-position: inside;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>`,
            icon: 'error',
            confirmButtonText: 'Đóng',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif
