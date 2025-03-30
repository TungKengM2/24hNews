    <!-- ====== request ====== -->
    <script src="/client/assets/js/lib/jquery-3.0.0.min.js"></script>
    <script src="/client/assets/js/lib/jquery-migrate-3.0.0.min.js"></script>
    <script src="/client/assets/js/lib/bootstrap.bundle.min.js"></script>
    <script src="/client/assets/js/lib/wow.min.js"></script>
    <script src="/client/assets/js/lib/jquery.fancybox.js"></script>
    <script src="/client/assets/js/lib/lity.js"></script>
    <script src="/client/assets/js/lib/swiper.min.js"></script>
    <script src="/client/assets/js/lib/jquery.waypoints.min.js"></script>
    <script src="/client/assets/js/lib/jquery.counterup.js"></script>
    <script src="/client/assets/js/lib/pace.js"></script>
    <script src="/client/assets/js/lib/back-to-top.js"></script>
    <script src="/client/assets/js/lib/parallaxie.js"></script>
    <script src="/client/assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiKey = '36277b82488afbd10f95af925ec6156a';
            const defaultCity = 'Hanoi';
            const weatherItem = document.querySelector('.item.position-relative');
            const weatherForm = document.querySelector('.weather-form');

            function fetchWeatherData(city) {
                fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`)
                    .then(response => response.json())
                    .then(data => {
                        const weatherIcon = data.weather[0].icon;
                        const weatherCity = data.name;
                        const weatherTemperature = data.main.temp;

                        document.getElementById('weather-city').textContent = `${weatherCity}`;
                        document.getElementById('weather-temperature').textContent = `${weatherTemperature}°C`;
                        document.getElementById('weather-icon').src =
                            `http://openweathermap.org/img/wn/${weatherIcon}@2x.png`;
                    })
                    .catch(error => console.error('Error fetching weather data:', error));
            }

            weatherItem.addEventListener('mouseenter', () => {
                weatherForm.style.display = 'block';
            });

            weatherItem.addEventListener('mouseleave', (e) => {
                if (!weatherItem.contains(e.relatedTarget)) {
                    weatherForm.style.display = 'none';
                }
            });

            window.updateWeather = function() {
                const cityInput = document.getElementById('cityInput');
                const city = cityInput.value.trim();
                if (city) {
                    fetchWeatherData(city);
                    weatherForm.style.display = 'none';
                    cityInput.value = '';
                }
            };

            fetchWeatherData(defaultCity);
        });
    </script>

    <script>
        function updateDate() {
            const daysOfWeek = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
            const months = ['tháng 1', 'tháng 2', 'tháng 3', 'tháng 4', 'tháng 5', 'tháng 6', 'tháng 7', 'tháng 8',
                'tháng 9', 'tháng 10', 'tháng 11', 'tháng 12'
            ];

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
        $(document).ready(function() {
            $("#bookmarkButton").click(function() {
                let articleId = $(this).data("article-id");

                $.ajax({
                    url: "/save-article",
                    type: "POST",
                    data: {
                        article_id: articleId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Thành công!",
                            text: "Bài viết đã được lưu.",
                            timer: 2000
                        });
                        $("#bookmarkText").text("Đã lưu");
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                            "Lỗi khi lưu bài viết!";
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
