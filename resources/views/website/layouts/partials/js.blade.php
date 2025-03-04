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
    document.addEventListener('DOMContentLoaded', function() {
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

                document.getElementById('weather-city').textContent = `Thành phố: ${weatherCity}`;
                document.getElementById('weather-description').textContent = `Mô tả: ${weatherDescription}`;
                document.getElementById('weather-temperature').textContent = `Nhiệt độ: ${weatherTemperature}°C`;
                document.getElementById('weather-icon').src = `http://openweathermap.org/img/wn/${weatherIcon}@2x.png`;
                document.getElementById('weather-humidity').textContent = `Độ ẩm: ${weatherHumidity}%`;
            })
            .catch(error => console.error('Error fetching weather data:', error));
    });
</script>