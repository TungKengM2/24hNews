<div class="nav-search-style1">
    <div class="row justify-content-center align-items-center gx-lg-5">
        <div class="col-lg-4">
            <div class="info">
                <div class="foot-logo mx-5">
                    <img src="{{ asset('images/logo24news.png') }}" alt="logo" class="w-75 h-80" >
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="form" id="searchForm" method="GET">
                @csrf
                <div class="form-group">
                    <span class="icon">
                        <i class="la la-search"></i>
                    </span>
                    <input type="text" name="keyword" id="searchInput" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." required>
                    <div id="suggestionsList" class="suggestions-list" style="display: none;"></div>
                </div>
            </form>

            <div id="searchResults" class="search-results mt-4" style="display: none;">
                <h6>Kết quả tìm kiếm cho: "<span id="searchKeyword"></span>"</h6>
                <div id="searchResultsList"></div>
            </div>
            <script>
            // Hàm đánh dấu từ khóa trong gợi ý
            function highlightKeyword(text, keyword) {
                if (!keyword) return text;

                // Tạo biểu thức chính quy để tìm từ khóa (không phân biệt hoa thường)
                const regex = new RegExp(`(${keyword.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')})`, 'gi');

                // Thay thế từ khóa bằng phiên bản được bôi đậm
                return text.replace(regex, '<strong>$1</strong>');
            }

            // Xử lý sự kiện submit form tìm kiếm
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const keyword = this.querySelector('input[name="keyword"]').value.trim();

                if (!keyword) {
                    alert('Vui lòng nhập từ khóa để tìm kiếm');
                    keyword.focus();
                    return;
                }

                // Ẩn danh sách gợi ý khi submit
                document.getElementById('suggestionsList').style.display = 'none';

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
                        document.getElementById('searchResultsList').innerHTML = '<p>Không có kết quả.</p>';
                    });
            });

            // Xử lý gợi ý tìm kiếm khi nhập
            const searchInput = document.getElementById('searchInput');
            const suggestionsList = document.getElementById('suggestionsList');

            // Biến để theo dõi thời gian chờ
            let debounceTimer;
            let categoryDebounceTimer;
            let tagDebounceTimer;

            // Hàm để lấy gợi ý tiêu đề bài viết
            function fetchTitleSuggestions(keyword) {
                return fetch(`/suggestions?keyword=${encodeURIComponent(keyword)}`)
                    .then(response => response.json());
            }

            // Hàm để lấy gợi ý danh mục
            function fetchCategorySuggestions(keyword) {
                return fetch(`/category-suggestions?keyword=${encodeURIComponent(keyword)}`)
                    .then(response => response.json());
            }

            // Hàm để lấy gợi ý thẻ tag
            function fetchTagSuggestions(keyword) {
                return fetch(`/tag-suggestions?keyword=${encodeURIComponent(keyword)}`)
                    .then(response => response.json());
            }

            // Xử lý sự kiện khi nhập vào ô tìm kiếm
            searchInput.addEventListener('input', function() {
                const keyword = this.value.trim();

                // Xóa bộ đếm thời gian trước đó
                clearTimeout(debounceTimer);
                clearTimeout(categoryDebounceTimer);
                clearTimeout(tagDebounceTimer);

                // Nếu từ khóa quá ngắn, ẩn gợi ý
                if (keyword.length < 2) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                // Đặt bộ đếm thời gian mới để tránh gửi quá nhiều request
                debounceTimer = setTimeout(() => {
                    // Sử dụng Promise.all để gửi cả ba request cùng lúc
                    Promise.all([
                        fetchTitleSuggestions(keyword),
                        fetchCategorySuggestions(keyword),
                        fetchTagSuggestions(keyword)
                    ])
                    .then(([titleData, categoryData, tagData]) => {
                        // Lưu trữ kết quả tiêu đề riêng biệt
                        let titleSuggestions = [];
                        // Kết hợp kết quả từ hai nguồn (tag và category)
                        let tagCategorySuggestions = [];

                        // Thêm gợi ý tiêu đề bài viết
                        if (titleData.suggestions && titleData.suggestions.length > 0) {
                            titleData.suggestions.forEach(suggestion => {
                                titleSuggestions.push({
                                    text: suggestion.title || suggestion,
                                    slug: suggestion.slug || '',
                                    type: 'title',
                                });
                            });
                        }

                        // Thêm gợi ý danh mục
                        if (categoryData.suggestions && categoryData.suggestions.length > 0) {
                            categoryData.suggestions.forEach(category => {
                                tagCategorySuggestions.push({
                                    text: category.name,
                                    type: 'category',
                                    slug: category.slug
                                });
                            });
                        }

                        // Thêm gợi ý thẻ tag
                        if (tagData.suggestions && tagData.suggestions.length > 0) {
                            tagData.suggestions.forEach(tag => {
                                tagCategorySuggestions.push({
                                    text: tag.name,
                                    type: 'tag',
                                    tag_id: tag.tag_id
                                });
                            });
                        }

                        // Sắp xếp để đảm bảo có cả tag và category nếu có thể
                        tagCategorySuggestions.sort((a, b) => {
                            // Ưu tiên hiển thị tag trước
                            if (a.type === 'tag' && b.type !== 'tag') return -1;
                            if (a.type !== 'tag' && b.type === 'tag') return 1;
                            return 0;
                        });

                        // Giới hạn số lượng gợi ý
                        titleSuggestions = titleSuggestions.slice(0, 5); // Tối đa 5 gợi ý tiêu đề
                        tagCategorySuggestions = tagCategorySuggestions.slice(0, 5); // Tối đa 5 gợi ý tag/category

                        // Kiểm tra xem có gợi ý nào không
                        if (titleSuggestions.length > 0 || tagCategorySuggestions.length > 0) {
                            // Tạo HTML cho danh sách gợi ý
                            let html = '';

                            // Thêm phần tiêu đề bài viết nếu có
                            if (titleSuggestions.length > 0) {
                                html += '<div class="suggestion-section-header">Tiêu đề bài viết</div>';

                                titleSuggestions.forEach(suggestion => {
                                    const highlightedText = highlightKeyword(suggestion.text, keyword);
                                    html += `<div class="suggestion-item title" data-type="title" data-slug="${suggestion.slug}">${highlightedText}</div>`;
                                });
                            }

                            // Thêm phần tag và category nếu có
                            if (tagCategorySuggestions.length > 0) {
                                html += '<div class="suggestion-section-header">Danh mục và thẻ</div>';

                                tagCategorySuggestions.forEach(suggestion => {
                                    const highlightedText = highlightKeyword(suggestion.text, keyword);
                                    let cssClass = 'suggestion-item';

                                    if (suggestion.type === 'category') {
                                        cssClass += ' category';
                                    } else if (suggestion.type === 'tag') {
                                        cssClass += ' tag';
                                    }

                                    html += `<div class="${cssClass}" data-type="${suggestion.type}"
                                        ${suggestion.slug ? `data-slug="${suggestion.slug}"` : ''}
                                        ${suggestion.tag_id ? `data-tag-id="${suggestion.tag_id}"` : ''}>${highlightedText}</div>`;
                                });
                            }

                            // Hiển thị danh sách gợi ý
                            suggestionsList.innerHTML = html;
                            suggestionsList.style.display = 'block';

                            // Thêm sự kiện click cho các mục gợi ý
                            document.querySelectorAll('.suggestion-item').forEach(item => {
                                item.addEventListener('click', function() {
                                    const type = this.getAttribute('data-type');

                                    if (type === 'category') {
                                        // Nếu là danh mục, chuyển hướng đến trang danh mục
                                        const slug = this.getAttribute('data-slug');
                                        window.location.href = `/danh-muc/${slug}`;
                                    } else if (type === 'tag') {
                                        // Nếu là thẻ tag, chuyển hướng đến trang tag
                                        const tagId = this.getAttribute('data-tag-id');
                                        window.location.href = `/tags/${tagId}`;
                                    } else if (type === 'title') {
                                        // Nếu là tiêu đề bài viết, chuyển hướng đến trang bài viết
                                        const slug = this.getAttribute('data-slug');
                                        if (slug) {
                                            window.location.href = `/bai-viet/${slug}`;
                                        } else {
                                            // Fallback nếu không có slug
                                            searchInput.value = this.textContent;
                                            suggestionsList.style.display = 'none';
                                            document.getElementById('searchForm').dispatchEvent(new Event('submit'));
                                        }
                                    }
                                });
                            });
                        } else {
                            // Nếu không có gợi ý, ẩn danh sách
                            suggestionsList.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        suggestionsList.style.display = 'none';
                    });
                }, 300); // Đợi 300ms sau khi người dùng ngừng gõ
            });

            // Ẩn gợi ý khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
            </script>
        </div>
    </div>
</div>
