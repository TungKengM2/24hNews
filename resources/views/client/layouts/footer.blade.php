<!-- Footer -->
<div class="footer">
    <div class="logo">24H<span>N</span>EWS</div>
    <p>&copy; 2025 VNExpress - Tất cả quyền được bảo lưu.</p>
</div>

<script>
    // Cập nhật thời gian hiện tại
    function updateDateTime() {
        const now = new Date();
        const days = ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"];
        const formattedDate = `${days[now.getDay()]}, ${now.getDate()}/${now.getMonth() + 1}/${now.getFullYear()}`;
        document.getElementById("date-time").innerText = formattedDate;
    }
    updateDateTime();
</script>

</body>
</html>