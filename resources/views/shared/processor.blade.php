<script>
    // Hàm cập nhật thanh tiến độ
    function updateProgressBar() {
        try {
            console.log('updateProgressBar called');

            // Đếm số tiêu chí đạt
            let passedCount = 0;
            const criteriaItems = document.querySelectorAll('.criteria-item');

            criteriaItems.forEach(item => {
                if (item.classList.contains('passed')) {
                    passedCount++;
                }
            });

            console.log('updateProgressBar - Số tiêu chí đạt:', passedCount);

            // Cập nhật thanh tiến độ
            const progressBar = document.getElementById('criteria-progress-bar');
            const criteriaCount = document.getElementById('criteria-count');

            if (progressBar) {
                const percentage = (passedCount / 4) * 100;
                progressBar.style.height = percentage + '%';
                console.log('updateProgressBar - Tiến độ:', percentage + '%');
            }

            if (criteriaCount) {
                criteriaCount.textContent = passedCount + '/4 tiêu chí đạt';
            }
        } catch (error) {
            console.error('Lỗi khi cập nhật thanh tiến độ:', error);
        }
    }

    // Hàm kiểm tra tiêu chí nội dung
    function checkContentCriteria() {
        try {
            console.log('checkContentCriteria called');

            // Lấy số từ
            let wordCount = getWordCount();

            // Đảm bảo wordCount là số
            wordCount = parseInt(wordCount, 10) || 0;

            console.log('checkContentCriteria - Số từ:', wordCount);
            console.log('checkContentCriteria - Điều kiện:', wordCount >= 800 && wordCount <= 1500);

            // Cập nhật trạng thái tiêu chí
            const criteriaItem = document.getElementById('criteria-content');
            const icon = criteriaItem ? criteriaItem.querySelector('.criteria-icon') : null;

            if (criteriaItem && icon) {
                if (wordCount >= 800 && wordCount <= 1500) {
                    // Đạt tiêu chí
                    criteriaItem.classList.remove('failed');
                    criteriaItem.classList.add('passed');
                    icon.classList.remove('failed');
                    icon.classList.add('passed');
                    icon.innerHTML = '✓'; // Checkmark

                    console.log('checkContentCriteria - Tiêu chí đạt');
                    return true;
                } else {
                    // Không đạt tiêu chí
                    criteriaItem.classList.remove('passed');
                    criteriaItem.classList.add('failed');
                    icon.classList.remove('passed');
                    icon.classList.add('failed');
                    icon.innerHTML = '✗'; // X mark

                    console.log('checkContentCriteria - Tiêu chí không đạt');
                    return false;
                }
            }

            return false;
        } catch (error) {
            console.error('Lỗi khi kiểm tra tiêu chí nội dung:', error);
            return false;
        }
    }

    // Hàm trợ giúp đếm từ trong nội dung HTML
    function countWordsInHTML(html) {
        if (!html || typeof html !== 'string') return 0;

        // Tạo một div tạm thời
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;

        // Lấy văn bản từ div (loại bỏ tất cả các thẻ HTML)
        let text = tempDiv.textContent || tempDiv.innerText || '';

        // Loại bỏ các ký tự đặc biệt và khoảng trắng thừa
        text = text.replace(/[\n\r]+/g, ' ').trim();

        // Đếm số từ
        if (!text) return 0;
        return text.split(/\s+/).filter(word => word.length > 0).length;
    }

    // Hàm lấy số từ từ TinyMCE theo tài liệu chính thức
    function getWordCount() {
        try {
            // Sử dụng API chính thức của TinyMCE wordcount plugin
            if (window.tinymce && window.tinymce.get('full-featured')) {
                const editor = window.tinymce.get('full-featured');

                // Kiểm tra nếu plugin wordcount được tải
                if (editor.plugins && editor.plugins.wordcount) {
                    // Theo tài liệu: https://www.tiny.cloud/docs/tinymce/latest/wordcount/
                    const wordcountPlugin = editor.plugins.wordcount;

                    // Log ra tất cả các phương thức của plugin để debug
                    console.log('WordCount plugin methods:', Object.keys(wordcountPlugin));

                    // Thử các phương thức khác nhau
                    if (typeof wordcountPlugin.getCount === 'function') {
                        const count = wordcountPlugin.getCount();
                        console.log('wordcountPlugin.getCount():', count);
                        return count;
                    } else if (wordcountPlugin.body && typeof wordcountPlugin.body.getWordCount === 'function') {
                        const count = wordcountPlugin.body.getWordCount();
                        console.log('wordcountPlugin.body.getWordCount():', count);
                        return count;
                    } else if (wordcountPlugin.body && typeof wordcountPlugin.body.words === 'number') {
                        const count = wordcountPlugin.body.words;
                        console.log('wordcountPlugin.body.words:', count);
                        return count;
                    } else {
                        // Thử lấy trực tiếp từ DOM
                        const wordCountEl = document.querySelector('.tox-statusbar__wordcount');
                        if (wordCountEl) {
                            const text = wordCountEl.textContent;
                            const match = text.match(/(\d+)\s+words/);
                            if (match && match[1]) {
                                return parseInt(match[1], 10);
                            }
                        }
                    }
                }

                // Nếu không có plugin, đếm từ trong nội dung
                const content = editor.getContent({format: 'text'});
                if (content) {
                    return content.trim().split(/\s+/).filter(word => word.length > 0).length;
                }
            }

            return 0;
        } catch (error) {
            console.error('Lỗi khi đếm từ:', error);
            return 0;
        }
    }

    // Verification Criteria System
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize criteria tracking
        const criteria = {
            title: false,
            tags: false,
            thumbnail: false,
            content: false
        };

        // Get elements
        const titleInput = document.getElementById('title');
        const tagsSelect = document.getElementById('tags');
        const thumbnailInput = document.getElementById('thumbnail_url');
        const contentEditor = tinymce.get('full-featured');

        // Get criteria elements
        const criteriaItems = document.querySelectorAll('.criteria-item');
        const progressBar = document.getElementById('criteria-progress-bar');
        const criteriaCount = document.getElementById('criteria-count');

        // Function to update criteria status - make it global so it can be called from image validation
        window.updateCriteria = function() {
            console.log('updateCriteria called');
            let passedCount = 0;

            // Check title (50-60 characters)
            const titleLength = titleInput ? titleInput.value.trim().length : 0;

            // Cập nhật số ký tự hiện tại của tiêu đề
            const titleLengthElement = document.getElementById('current-title-length');
            if (titleLengthElement) {
                titleLengthElement.textContent = `(${titleLength} ký tự)`;

                // Đổi màu số ký tự dựa trên trạng thái
                if (titleLength >= 50 && titleLength <= 60) {
                    titleLengthElement.style.color = '#28a745'; // Xanh lá
                } else if (titleLength > 60) {
                    titleLengthElement.style.color = '#ffc107'; // Vàng - quá dài
                } else {
                    titleLengthElement.style.color = '#dc3545'; // Đỏ - chưa đủ
                }
            }

            if (titleLength >= 50 && titleLength <= 60) {
                criteria.title = true;
                updateCriteriaItem('criteria-title', true);
                passedCount++;
            } else {
                criteria.title = false;
                updateCriteriaItem('criteria-title', false);
            }

            // Check tags (2-5 tags selected)
            const selectedTags = $(tagsSelect).select2('data');
            const tagCount = selectedTags ? selectedTags.length : 0;

            // Cập nhật số lượng thẻ tag đã chọn
            const tagCountElement = document.getElementById('current-tag-count');
            if (tagCountElement) {
                tagCountElement.textContent = `(${tagCount} thẻ)`;

                // Đổi màu số lượng thẻ tag dựa trên trạng thái
                if (tagCount >= 2 && tagCount <= 5) {
                    tagCountElement.style.color = '#28a745'; // Xanh lá
                } else if (tagCount > 5) {
                    tagCountElement.style.color = '#ffc107'; // Vàng - quá nhiều
                } else {
                    tagCountElement.style.color = '#dc3545'; // Đỏ - chưa đủ
                }
            }

            if (tagCount >= 2 && tagCount <= 5) {
                criteria.tags = true;
                updateCriteriaItem('criteria-tags', true);
                passedCount++;
            } else {
                criteria.tags = false;
                updateCriteriaItem('criteria-tags', false);
            }

            // Check thumbnail (file selected and passed moderation)
            if (window.isImageValid) {
                criteria.thumbnail = true;
                updateCriteriaItem('criteria-thumbnail', true);
                passedCount++;
            } else {
                criteria.thumbnail = false;
                updateCriteriaItem('criteria-thumbnail', false);
            }

            // Check content (800-1500 words) - chỉ cập nhật biến criteria, không cập nhật giao diện
            if (contentEditor) {
                // Sử dụng hàm getWordCount() để lấy số từ
                let wordCount = getWordCount();

                // Đảm bảo wordCount là số
                wordCount = parseInt(wordCount, 10) || 0;

                // Log số từ để debug
                console.log('updateCriteria - Số từ trong bài viết:', wordCount);

                // Cập nhật biến criteria
                if (wordCount >= 800 && wordCount <= 1500) {
                    criteria.content = true;
                    // Không gọi updateCriteriaItem ở đây, để tránh xung đột với hàm checkContentCriteria
                    passedCount++;
                } else {
                    criteria.content = false;
                    // Không gọi updateCriteriaItem ở đây, để tránh xung đột với hàm checkContentCriteria
                }
            }

            // Update progress bar and count
            const percentage = (passedCount / 4) * 100;
            progressBar.style.height = percentage + '%';
            criteriaCount.textContent = passedCount + '/4 tiêu chí đạt';
        }

        // Function to update a criteria item's appearance
        function updateCriteriaItem(id, passed) {
            console.log('updateCriteriaItem called:', id, passed);
            const item = document.getElementById(id);
            if (!item) {
                console.error('Element not found:', id);
                return;
            }

            const icon = item.querySelector('.criteria-icon');
            const wasAlreadyPassed = item.classList.contains('passed');

            if (passed) {
                item.classList.remove('failed');
                item.classList.add('passed');
                icon.classList.remove('failed');
                icon.classList.add('passed');
                icon.innerHTML = '✓'; // Checkmark

                // Add animation if newly passed
                if (!wasAlreadyPassed) {
                    item.classList.add('just-passed');
                    setTimeout(() => {
                        item.classList.remove('just-passed');
                    }, 500);
                }
            } else {
                item.classList.remove('passed');
                item.classList.add('failed');
                icon.classList.remove('passed');
                icon.classList.add('failed');
                icon.innerHTML = '✗'; // X mark
            }
        }

        // Add event listeners
        if (titleInput) {
            titleInput.addEventListener('input', updateCriteria);
        }

        if (tagsSelect) {
            $(tagsSelect).on('change', updateCriteria);
        }

        // Content editor (TinyMCE) event
        // Khai báo hàm cập nhật số từ ở phạm vi toàn cục
        window.updateWordCount = function() {
            try {
                const wordCount = getWordCount();
                const wordCountElement = document.getElementById('current-word-count');

                if (wordCountElement) {
                    wordCountElement.textContent = `(${wordCount} từ)`;

                    // Đổi màu số từ dựa trên trạng thái
                    if (wordCount >= 800 && wordCount <= 1500) {
                        wordCountElement.style.color = '#28a745'; // Xanh lá
                    } else if (wordCount > 1500) {
                        wordCountElement.style.color = '#ffc107'; // Vàng - quá dài
                    } else {
                        wordCountElement.style.color = '#dc3545'; // Đỏ - chưa đủ
                    }
                }

                // Gọi hàm kiểm tra tiêu chí nội dung trực tiếp
                console.log('Gọi checkContentCriteria từ updateWordCount');
                checkContentCriteria();

                // Gọi updateCriteria để cập nhật các tiêu chí khác
                console.log('Gọi updateCriteria từ updateWordCount');
                window.updateCriteria();

                // Cập nhật thanh tiến độ
                setTimeout(function() {
                    updateProgressBar();
                }, 100);

                return wordCount;
            } catch (error) {
                console.error('Lỗi khi cập nhật số từ:', error);
                return 0;
            }
        };

        // Thêm sự kiện khi TinyMCE được khởi tạo
        if (!window.tinyMceInitialized) {
            window.tinyMceInitialized = true;

            // Thêm sự kiện vào window để lắng nghe khi TinyMCE được khởi tạo
            window.addEventListener('load', function() {
                console.log('Window loaded, checking for TinyMCE...');

                // Kiểm tra TinyMCE mỗi 100ms
                const checkTinyMCE = setInterval(function() {
                    if (window.tinymce && window.tinymce.get('full-featured')) {
                        console.log('TinyMCE found and initialized!');
                        clearInterval(checkTinyMCE);

                        const editor = window.tinymce.get('full-featured');

                        // Kiểm tra plugin wordcount
                        if (editor.plugins && editor.plugins.wordcount) {
                            console.log('WordCount plugin found:', editor.plugins.wordcount);
                        }

                        // Cập nhật số từ ban đầu
                        setTimeout(window.updateWordCount, 500);

                        // Lắng nghe sự kiện thay đổi nội dung
                        editor.on('input', function() {
                            console.log('TinyMCE input event fired');
                            window.updateWordCount();
                        });

                        editor.on('change', function() {
                            console.log('TinyMCE change event fired');
                            window.updateWordCount();
                        });

                        // Thêm sự kiện keyup để bắt kịp các thay đổi nhỏ
                        editor.on('keyup', function() {
                            console.log('TinyMCE keyup event fired');
                            window.updateWordCount();
                        });

                        // Thêm sự kiện WordCount để bắt kịp khi số từ thay đổi
                        if (editor.plugins && editor.plugins.wordcount) {
                            editor.plugins.wordcount.on('wordCountUpdate', function() {
                                console.log('TinyMCE wordCountUpdate event fired');
                                window.updateWordCount();
                            });
                        }

                        // Thêm sự kiện init để cập nhật ngay khi TinyMCE khởi tạo xong
                        editor.on('init', function() {
                            console.log('TinyMCE init event fired');
                            setTimeout(window.updateWordCount, 500);
                        });
                    }
                }, 100);
            });
        }

        // Cập nhật số từ ban đầu nếu TinyMCE đã được khởi tạo
        if (tinymce && tinymce.get('full-featured')) {
            console.log('TinyMCE already initialized, updating word count...');
            setTimeout(window.updateWordCount, 500);

            // Lắng nghe sự kiện thay đổi nội dung
            tinymce.get('full-featured').on('input', function() {
                updateCriteria();
                window.updateWordCount();
            });

            tinymce.get('full-featured').on('change', function() {
                updateCriteria();
                window.updateWordCount();
            });

            // Thêm sự kiện keyup để bắt kịp các thay đổi nhỏ
            tinymce.get('full-featured').on('keyup', function() {
                window.updateWordCount();
            });
        }

        // Make criteria items clickable to focus on corresponding fields
        criteriaItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                if (target === 'title') {
                    titleInput.focus();
                } else if (target === 'tags') {
                    $(tagsSelect).select2('open');
                } else if (target === 'thumbnail_url') {
                    thumbnailInput.click();
                } else if (target === 'content') {
                    if (tinymce && tinymce.get('full-featured')) {
                        tinymce.get('full-featured').focus();
                    }
                }
            });
        });

        // Initial check
        setTimeout(function() {
            updateCriteria(); // Cập nhật tiêu chí

            // Cập nhật số từ ban đầu
            try {
                const wordCount = getWordCount();
                console.log('Số từ ban đầu:', wordCount);

                const wordCountElement = document.getElementById('current-word-count');
                if (wordCountElement) {
                    wordCountElement.textContent = `(${wordCount} từ)`;

                    // Đổi màu số từ dựa trên trạng thái
                    if (wordCount >= 800 && wordCount <= 1500) {
                        wordCountElement.style.color = '#28a745'; // Xanh lá
                    } else if (wordCount > 1500) {
                        wordCountElement.style.color = '#ffc107'; // Vàng - quá dài
                    } else {
                        wordCountElement.style.color = '#dc3545'; // Đỏ - chưa đủ
                    }
                }
            } catch (error) {
                console.error('Lỗi khi cập nhật số từ ban đầu:', error);
            }
        }, 1000); // Slight delay to ensure all components are loaded

        // Đảm bảo phần tiêu chí xác thực cuộn theo khi người dùng cuộn trang
        const criteriaSection = document.querySelector('.verification-criteria');
        const mainCard = document.querySelector('.card.p-4');

        if (criteriaSection && mainCard) {
            // Lấy vị trí ban đầu của phần tiêu chí xác thực
            const initialOffset = criteriaSection.offsetTop;

            // Theo dõi sự kiện cuộn
            window.addEventListener('scroll', function() {
                // Lấy vị trí cuộn hiện tại
                const scrollPosition = window.scrollY;

                // Lấy chiều cao của thẻ card chính
                const cardHeight = mainCard.offsetHeight;

                // Nếu vị trí cuộn vượt quá vị trí ban đầu của phần tiêu chí xác thực
                // và vẫn trong phạm vi của thẻ card chính, thì cuộn phần tiêu chí xác thực theo
                if (scrollPosition > initialOffset && scrollPosition < initialOffset + cardHeight - criteriaSection.offsetHeight) {
                    criteriaSection.style.transform = `translateY(${scrollPosition - initialOffset}px)`;
                } else if (scrollPosition <= initialOffset) {
                    criteriaSection.style.transform = 'translateY(0)';
                }
            });
        }
    });
</script>
