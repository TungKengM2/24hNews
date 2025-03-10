<!-- Vendor JS -->
<script src="/admin/main/js/vendors.min.js"></script>
<script src="/admin/main/js/pages/chat-popup.js"></script>
<script src="/admin/main/../assets/icons/feather-icons/feather.min.js"></script>

<script src="/admin/main/../assets/vendor_components/apexcharts-bundle/irregular-data-series.js"></script>
<script src="/admin/main/../assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
<script src="/admin/main/../assets/vendor_components/zingchart_branded_version/zingchart.min.js"></script>
<script src="/admin/main/https://www.amcharts.com/lib/4/core.js"></script>
<script src="/admin/main/https://www.amcharts.com/lib/4/maps.js"></script>
<script src="/admin/main/https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="/admin/main/https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="/admin/main/https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- CrmX Admin App -->
<script src="/admin/main/js/template.js"></script>
<script src="/admin/main/js/demo.js"></script>
<script src="/admin/main/js/pages/dashboard.js"></script>
<script src="/admin/assets/vendor_components/select2/dist/js/select2.full.js"></script>


{{-- <script src="/admin/main/js/pages/data-table.js"></script> --}}

<script src="client/assets/js/lib/jquery-3.0.0.min.js"></script>
<script src="client/assets/js/lib/jquery-migrate-3.0.0.min.js"></script>
<script src="client/assets/js/lib/bootstrap.bundle.min.js"></script>
<script src="client/assets/js/lib/wow.min.js"></script>
<script src="client/assets/js/lib/jquery.fancybox.js"></script>
<script src="client/assets/js/lib/lity.js"></script>
<script src="client/assets/js/lib/swiper.min.js"></script>
<script src="client/assets/js/lib/jquery.waypoints.min.js"></script>
<script src="client/assets/js/lib/jquery.counterup.js"></script>
<!-- <script src="client/js/lib/pace.js"></script> -->
<script src="client/assets/js/lib/back-to-top.js"></script>
<script src="client/assets/js/lib/parallaxie.js"></script>
<script src="client/assets/js/main.js"></script>
<script>
    function updateDate() {
        const daysOfWeek = ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"];
        const months = ["/1", "/2", "/3", "/4", "/5", "/6", "/7", "/8", "/9", "/10", "/11", "/12"];

        const now = new Date();
        const dayOfWeek = daysOfWeek[now.getDay()];
        const day = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const formattedDate = `${dayOfWeek},  ${day}${month}/${year}`;
        document.getElementById("dateElement").innerText = formattedDate;
    }

    updateDate();
</script>

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
