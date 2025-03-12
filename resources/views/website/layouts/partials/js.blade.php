<script src="{{ asset('client/assets/js/lib/jquery-3.0.0.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/wow.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/jquery.fancybox.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/lity.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/swiper.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/jquery.counterup.js') }}"></script>
<!-- <script src="client/js/lib/pace.js"></script> -->
<script src="{{ asset('client/assets/js/lib/back-to-top.js') }}"></script>
<script src="{{ asset('client/assets/js/lib/parallaxie.js') }}"></script>
<script src="{{ asset('client/assets/js/main.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const apiKey = '36277b82488afbd10f95af925ec6156a'; // Thay thế bằng API key của bạn
        const city = 'Hanoi'; // Thay thế bằng tên thành phố bạn muốn lấy thông tin thời tiết

        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`)
            .then(response => response.json())
            .then(data => {
                const weatherIcon = data.weather[0].icon;
                const weatherCity = data.name;
                const weatherDescription = data.weather[0].description;
                const weatherTemperature = data.main.temp;
                const weatherHumidity = data.main.humidity;

                document.getElementById('weather-city').textContent = `${weatherCity}`;
                document.getElementById('weather-description').textContent = `${weatherDescription}`;
                document.getElementById('weather-temperature').textContent = `${weatherTemperature}°C`;
                document.getElementById('weather-icon').src = `http://openweathermap.org/img/wn/${weatherIcon}@2x.png`;
                document.getElementById('weather-humidity').textContent = `Độ ẩm: ${weatherHumidity}%`;
            })
            .catch(error => console.error('Error fetching weather data:', error));
    });
</script>

<script>
    function updateDate() {
        const daysOfWeek = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
        const months = ['tháng 1', 'tháng 2', 'tháng 3', 'tháng 4', 'tháng 5', 'tháng 6', 'tháng 7', 'tháng 8', 'tháng 9', 'tháng 10', 'tháng 11', 'tháng 12'];

        const now = new Date();
        const dayOfWeek = daysOfWeek[now.getDay()];
        const day = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const formattedDate = `${dayOfWeek}, ngày ${day} ${month} năm ${year}`;
        document.getElementById('dateElement').innerText = formattedDate;
    }

    updateDate();
</script>

{{-- BookMark --}}
<script>
    $(document).ready(function () {
    $("#bookmarkButton").click(function () {
        let articleId = $(this).data("article-id");

        $.ajax({
            url: "/save-article",
            type: "POST",
            data: {
                article_id: articleId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "Bài viết đã được lưu.",
                    timer: 2000
                });
                $("#bookmarkText").text("Đã lưu");
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Lỗi khi lưu bài viết!";
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: errorMessage
                });
            }
        });
    });
});
</script>
