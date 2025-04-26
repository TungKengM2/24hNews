<div class="nav-search-style1">
    <div class="row justify-content-center align-items-center gx-lg-5">
        <div class="col-lg-4">
            <div class="info">
                <h1>24News</h1>
                <p>Kênh hóng chuyện hàng đầu Việt Nam .</p>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="form" id="searchForm" method="GET">
                @csrf
                <span class="color-777 fst-italic text-capitalize mb-2 fsz-13px">Nhập Từ Khóa </span>
                <div class="form-group">
                    <span class="icon">
                        <i class="la la-search"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control" placeholder="Elon Musk ..." required>
                    <button type="submit">Tìm Kiếm </button>
                </div>
            </form>

            <div id="searchResults" class="search-results mt-4" style="display: none;">
                <h6>Kết quả tìm kiếm cho: "<span id="searchKeyword"></span>"</h6>
                <div id="searchResultsList"></div>
            </div>

            <script>
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const keyword = this.querySelector('input[name="keyword"]').value.trim();

                if (!keyword) {
                    alert('Vui lòng nhập từ khóa để tìm kiếm');
                    keyword.focus();
                    return;
                }

                // Hiển thị loading state
                document.getElementById('searchResults').style.display = 'block';
                document.getElementById('searchKeyword').textContent = keyword;
                document.getElementById('searchResultsList').innerHTML = '<p>Đang tìm kiếm...</p>';

                // Gửi request AJAX
                fetch(`/search?keyword=${encodeURIComponent(keyword)}`)
                    .then(response => response.json())
                    .then(data => {
                        const resultsList = document.getElementById('searchResultsList');

                        if (data.results && data.results.length > 0) {
                            let html = '<ul>';
                            data.results.forEach(result => {
                                html += `
                                    <li>
                                        <a href="${result.url}" class="btn btn-block">${result.title}</a>
                                    </li>
                                `;
                            });
                            html += '</ul>';
                            resultsList.innerHTML = html;
                        } else {
                            resultsList.innerHTML = '<p>Không tìm thấy kết quả nào.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('searchResultsList').innerHTML = '<p>Có lỗi xảy ra khi tìm kiếm.</p>';
                    });
            });
            </script>
        </div>
    </div>
</div>
