 <!-- Vendor JS -->
 <script src="/admin/main/js/vendors.min.js"></script>
 <script src="/admin/main/js/pages/chat-popup.js"></script>
 <script src="/admin/main/../assets/icons/feather-icons/feather.min.js"></script>
 {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

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


 <script src="/admin/main/js/pages/c3-axis.js"></script>
 <script src="/admin../assets/vendor_components/c3/d3.min.js"></script>
 <script src="/admin../assets/vendor_components/c3/c3.min.js"></script>
 <script src="/admin/main/js/pages/chat-popup.js"></script>

 <script src="/admin../assets/vendor_components/raphael/raphael.min.js"></script>
 <script src="/admin../assets/vendor_components/morris.js/morris.min.js"></script>


 {{-- Thống Kê Tài Khoản --}}
 <script>
     $(document).ready(function() {
         $.ajax({
             url: "{{ route('admin.userStats') }}", // Route API
             type: "GET",
             dataType: "json",
             success: function(response) {
                 let formattedData = response.map(item => ({
                     period: item.period, // Thời gian (tháng)
                     user: item.users,
                     author: item.authors,
                     moderator: item.moderators
                 }));

                 // Xóa chart cũ trước khi vẽ mới
                 $('#area-chart').empty();

                 new Morris.Line({
                     element: 'area-chart',
                     data: formattedData,
                     xkey: 'period',
                     ykeys: ['user', 'author', 'moderator'],
                     labels: ['Người Dùng', 'Tác Giả', 'Kiểm Duyệt Viên'],
                     pointSize: 3,
                     lineWidth: 3,
                     hideHover: 'auto',
                     lineColors: ['#3e8ef7', '#17b3a3',
                         '#0bb2d4'
                     ], // Màu tương ứng với 3 role
                     resize: true,
                     xLabels: "month", // Hiển thị theo tháng
                     parseTime: false // Tránh lỗi thời gian
                 });
             },
             error: function(xhr, status, error) {
                 console.error("Lỗi khi tải dữ liệu: ", error);
             }
         });
     });
 </script>


 {{-- Thống Kê Tương Tác --}}

 <script>
     $(document).ready(function() {
         $.ajax({
             url: "{{ route('admin.articleStats') }}", // API lấy dữ liệu
             type: "GET",
             dataType: "json",
             success: function(response) {
                 new Morris.Donut({
                     element: 'donut-chart',
                     data: [{
                             label: "Lượt Thích",
                             value: response.likes
                         },
                         {
                             label: "Bình Luận",
                             value: response.comments
                         },
                         {
                             label: "Lượt Xem",
                             value: response.views
                         }
                     ],
                     colors: ['#3e8ef7', '#17b3a3', '#0bb2d4'], // Màu sắc từng phần
                     resize: true
                 });
             },
             error: function(xhr, status, error) {
                 console.error("Lỗi khi tải dữ liệu: ", error);
             }
         });
     });
 </script>

 {{-- Upload ảnh cho admin --}}
 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const imageUpload = document.getElementById("avatarUpload");
         const imagePreview = document.getElementById("avatarPreview");

         document.querySelector(".avatar-edit").addEventListener("click", function() {
             imageUpload.click();
         });

         imageUpload.addEventListener("change", function() {
             if (this.files && this.files[0]) {
                 const formData = new FormData();
                 formData.append("image", this.files[0]); // Attach the image to the FormData
                 formData.append("_token", "{{ csrf_token() }}"); // Add the CSRF token for security

                 // Send the request to the server to upload the image
                 fetch("{{ route('profile.upload-avatar') }}", {
                         method: "POST",
                         body: formData
                     })
                     .then(response => {
                         if (!response.ok) {
                             throw new Error("Error uploading the image!");
                         }
                         return response.json();
                     })
                     .then(data => {
                         if (data.success) {
                             // Update the avatar preview with the new image URL
                             imagePreview.src = data.image_url;
                         } else {
                             alert("Error uploading the image.");
                         }
                     })
                     .catch(error => {
                         console.error("Error:", error);
                         alert("An error occurred while uploading the image.");
                     });

                 this.value = ""; // Reset input to allow re-uploading the same file
             }
         });
     });
 </script>
