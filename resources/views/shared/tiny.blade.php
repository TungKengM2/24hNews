<script>
    // Tạo biến toàn cục để kiểm soát việc tự động quét ảnh
    window.disableAutoImageModeration = false;
    // Tạo biến để phân biệt giữa quét tự động và quét do người dùng thực hiện hành động
    window.userInitiatedImageScan = false;

    // Kiểm tra xem trang hiện tại có phải là trang edit hay không
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.href;
        // Nếu đang ở trang edit, vô hiệu hóa việc tự động kiểm duyệt
        if (currentUrl.includes('/author/articles/') && currentUrl.includes('/edit')) {
            console.log('Đang ở trang edit bài viết, vô hiệu hóa tự động kiểm duyệt khi tải trang');
            window.disableAutoImageModeration = true;
        }
    });

    window.blockedImages = [];
    window.checkingImages = false;
    window.uploadingImages = 0;
    window.importingFromWord = false;
    window._premoderatedImages = {};

    const fetchApi = import(
        'https://unpkg.com/@microsoft/fetch-event-source@2.0.1/lib/esm/index.js'
    ).then((module) => module.fetchEventSource);

    // This example stores the OpenAI API key in the client side integration. This is not recommended for any purpose.
    // Instead, an alternate method for retrieving the API key should be used.
    const openai_api_key = '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';
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    window.blockedImages = window.blockedImages || [];
    window.checkingImages = false;

    function resetBlockedImagesList() {
        window.blockedImages = [];
        if (document.getElementById('has_blocked_images')) {
            document.getElementById('has_blocked_images').value = 'false';
        }
        if (document.getElementById('blocked_images_list')) {
            document.getElementById('blocked_images_list').value = '[]';
        }
        console.log('Đã reset danh sách ảnh bị chặn');
    }

    document.addEventListener('DOMContentLoaded', function() {
        resetBlockedImagesList();

        fetch('/tinymce/clear-blocked-images')
            .then(response => response.json())
            .then(data => {
                console.log('Kết quả xóa thông tin ảnh bị chặn:', data);
            })
            .catch(error => {
                console.error('Lỗi khi gọi API xóa thông tin ảnh bị chặn:', error);
            });

        document.querySelectorAll('.alert.alert-warning').forEach(function(alert) {
            if (alert.textContent.includes('Một số hình ảnh đã bị chặn')) {
                const closeButton = document.createElement('button');
                closeButton.type = 'button';
                closeButton.className = 'close';
                closeButton.innerHTML = '&times;';
                closeButton.setAttribute('data-dismiss', 'alert');
                closeButton.setAttribute('aria-label', 'Close');

                alert.appendChild(closeButton);

                closeButton.addEventListener('click', function() {
                    alert.style.display = 'none';
                });

                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000);
            }
        });
    });

    function removeBlockedImagesFromContent(editor) {
        if (!editor || window.blockedImages.length === 0) {
            return;
        }

        var content = editor.getContent();
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;

        var removedCount = 0;

        window.blockedImages.forEach(function(blockedUrl) {
            var images = tempDiv.querySelectorAll('img');

            for (var i = 0; i < images.length; i++) {
                var img = images[i];
                var src = img.getAttribute('src');

                if (src === blockedUrl || src.includes(blockedUrl)) {
                    if (img.parentNode) {
                        img.parentNode.removeChild(img);
                        removedCount++;
                    }
                }
            }
        });

        if (removedCount > 0) {
            editor.setContent(tempDiv.innerHTML);
            console.log('Đã xóa', removedCount, 'hình ảnh bị chặn khỏi nội dung');
        }

        return removedCount;
    }

    tinymce
        .init({
            menubar: 'file edit view insert format tools table tc help',
            selector: 'textarea#full-featured',
            plugins: 'importword exportword exportpdf preview searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media table charmap pagebreak anchor insertdatetime advlist lists wordcount help formatpainter permanentpen charmap emoticons',
            toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | image media link anchor',
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            // skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; background-color: #f4f4f4; color: #333;}',
            theme: 'silver',
            paste_data_images: true,
            automatic_uploads: true,
            powerpaste_allow_local_images: true,
            images_upload_credentials: true,
            images_upload_base_path: '/storage',
            images_reuse_filename: true,
            images_dataimg_filter: function(img) {
                return true;
            },
            convert_urls: false,
            relative_urls: false,
            images_upload_url: '/author/tinymce/upload',

            paste_as_text: false,
            paste_remove_styles_if_webkit: false,
            paste_remove_styles: false,
            paste_filter_drop: false,
            paste_strip_class_attributes: 'none',
            paste_merge_formats: false,

            paste_webkit_styles: 'color font-size font-family font-weight text-decoration display float width height margin padding border',

            paste_retain_style_properties: 'all',
            paste_retain_class_attributes: 'all',

            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'merge',
            powerpaste_block_drop: false,

            paste_preprocess: function(plugin, args) {
                console.log('Bắt đầu xử lý paste_preprocess');
                const div = document.createElement('div');
                div.innerHTML = args.content;

                const allElements = div.querySelectorAll('*');
                allElements.forEach(function(el) {
                    if (el.style) {
                        el.style.removeProperty('background');
                        el.style.removeProperty('background-color');
                        el.style.removeProperty('background-image');

                        if (el.tagName === 'IMG') {
                            if (!el.style.width && !el.hasAttribute('width') && el.naturalWidth) {
                                el.setAttribute('width', el.naturalWidth);
                            }
                            if (!el.style.height && !el.hasAttribute('height') && el.naturalHeight) {
                                el.setAttribute('height', el.naturalHeight);
                            }

                            if (!el.style.display) {
                                el.style.display = 'inline';
                            }

                            if (el.style.margin === '0px auto' || el.style.margin === 'auto') {
                                el.style.margin = '0';
                            }

                            // Đảm bảo tất cả hình ảnh đều cần kiểm duyệt
                            el.setAttribute('data-need-moderation', 'true');
                            el.classList.add('waiting-moderation');

                            // Xóa các thuộc tính TinyMCE có thể gây trở ngại
                            ['data-mce-src', 'data-mce-selected', 'data-mce-object',
                                'data-mce-placeholder', 'contenteditable', 'data-mce-resize',
                                'data-mce-bogus'
                            ].forEach(attr => {
                                if (el.hasAttribute(attr)) {
                                    el.removeAttribute(attr);
                                }
                            });
                        }
                    }

                    if (el.hasAttribute('bgcolor')) {
                        el.removeAttribute('bgcolor');
                    }

                    if (el.className && (
                            el.className.includes('bg-') ||
                            el.className.includes('background-')
                        )) {
                        const classes = el.className.split(' ');
                        const filteredClasses = classes.filter(cls =>
                            !cls.startsWith('bg-') &&
                            !cls.includes('background-')
                        );
                        el.className = filteredClasses.join(' ');
                    }
                });

                const brs = div.querySelectorAll('br');
                brs.forEach(br => {
                    if (br.parentNode && br.parentNode.tagName === 'P' &&
                        br.parentNode.childNodes.length === 1) {} else {
                        if (br.nextSibling && br.nextSibling.nodeType === 3 &&
                            br.previousSibling && br.previousSibling.nodeType === 3) {
                            const wrapper = document.createElement('p');
                            wrapper.appendChild(br.cloneNode());
                            br.parentNode.replaceChild(wrapper, br);
                        }
                    }
                });

                // Xử lý các thẻ p trống hoặc chỉ chứa &nbsp;
                const emptyParagraphs = div.querySelectorAll('p');
                emptyParagraphs.forEach(p => {
                    const content = p.innerHTML.trim();
                    if (content === '' || content === '&nbsp;' || content === '<br>' || content ===
                        '<br />') {
                        // Nếu là thẻ p trống và không phải là thẻ p duy nhất
                        if (p.parentNode && p.parentNode.children.length > 1) {
                            p.parentNode.removeChild(p);
                        }
                    }
                });

                // Xử lý đặc biệt cho cấu trúc HTML khi paste
                // Tìm tất cả các thẻ p có chứa ảnh và text
                const mixedParagraphs = Array.from(div.querySelectorAll('p')).filter(p => {
                    const hasImage = p.querySelector('img') !== null;
                    const hasText = Array.from(p.childNodes).some(node =>
                        node.nodeType === 3 && node.textContent.trim() !== '');
                    return hasImage && hasText;
                });

                // Xử lý các thẻ p có chứa cả ảnh và text
                mixedParagraphs.forEach(p => {
                    // Tạo một fragment để chứa nội dung mới
                    const fragment = document.createDocumentFragment();

                    // Tạo thẻ p mới cho nội dung trước ảnh đầu tiên
                    let currentP = document.createElement('p');
                    fragment.appendChild(currentP);

                    // Duyệt qua từng node con của thẻ p
                    Array.from(p.childNodes).forEach(node => {
                        if (node.nodeType === 1 && node.tagName === 'IMG') {
                            // Nếu gặp ảnh, tạo thẻ p mới chỉ chứa ảnh
                            const imgP = document.createElement('p');
                            imgP.style.margin = '0';
                            imgP.style.padding = '0';
                            imgP.appendChild(node.cloneNode(true));
                            fragment.appendChild(imgP);

                            // Tạo thẻ p mới cho nội dung sau ảnh
                            currentP = document.createElement('p');
                            fragment.appendChild(currentP);
                        } else {
                            // Nếu không phải ảnh, thêm vào thẻ p hiện tại
                            currentP.appendChild(node.cloneNode(true));
                        }
                    });

                    // Xóa các thẻ p trống
                    Array.from(fragment.querySelectorAll('p')).forEach(para => {
                        if (para.innerHTML.trim() === '' || para.innerHTML.trim() ===
                            '&nbsp;' ||
                            para.innerHTML.trim() === '<br>' || para.innerHTML.trim() ===
                            '<br />') {
                            fragment.removeChild(para);
                        }
                    });

                    // Thay thế thẻ p gốc bằng fragment
                    if (p.parentNode) {
                        p.parentNode.replaceChild(fragment, p);
                    }
                });

                // Xử lý đặc biệt cho ảnh khi paste
                const images = div.querySelectorAll('img');

                if (images.length > 0) {
                    console.log('Tìm thấy ' + images.length + ' hình ảnh trong nội dung paste');

                    // Giải pháp mới: Thay thế tất cả ảnh bằng placeholder và xử lý sau
                    [...images].forEach((img, index) => {
                        if (img.src) {
                            const imgId = 'img-paste-' + Date.now() + '-' + index;
                            const originalSrc = img.src;

                            // Tạo một placeholder để giữ vị trí cho ảnh
                            const placeholder = document.createElement('img');
                            placeholder.setAttribute('src', originalSrc); // Giữ nguyên src để hiển thị
                            placeholder.setAttribute('data-original-src', originalSrc);
                            placeholder.setAttribute('data-paste-id', imgId);
                            placeholder.setAttribute('data-need-moderation', 'true');
                            placeholder.setAttribute('data-mce-src', originalSrc);
                            placeholder.classList.add('waiting-moderation');

                            // Sao chép các thuộc tính kích thước từ ảnh gốc
                            if (img.hasAttribute('width')) {
                                placeholder.setAttribute('width', img.getAttribute('width'));
                            }
                            if (img.hasAttribute('height')) {
                                placeholder.setAttribute('height', img.getAttribute('height'));
                            }

                            // Đặt style để tránh khoảng cách không mong muốn
                            placeholder.style.display = 'inline-block';
                            placeholder.style.verticalAlign = 'middle';

                            // Thay thế ảnh gốc bằng placeholder
                            if (img.parentNode) {
                                img.parentNode.replaceChild(placeholder, img);
                            }

                            // Đảm bảo ảnh được bao bọc trong thẻ p hoặc div
                            if (placeholder.parentNode && placeholder.parentNode.tagName !== 'P' &&
                                placeholder.parentNode.tagName !== 'DIV') {
                                const wrapper = document.createElement('p');
                                wrapper.style.margin = '0';
                                wrapper.style.padding = '0';
                                placeholder.parentNode.replaceChild(wrapper, placeholder);
                                wrapper.appendChild(placeholder);
                            }

                            // Lưu trữ thông tin ảnh gốc để xử lý sau
                            setTimeout(() => {
                                // Tạo một ảnh mới với src là ảnh gốc
                                const newImg = new Image();
                                newImg.onload = function() {
                                    // Khi ảnh đã tải xong, gọi API kiểm duyệt
                                    const formData = new FormData();
                                    fetch(originalSrc)
                                        .then(res => res.blob())
                                        .then(blob => {
                                            const fileName =
                                                `pasted-image-${Date.now()}-${index}.png`;
                                            const file = new File([blob], fileName, {
                                                type: 'image/png'
                                            });

                                            formData.append('file', file);
                                            formData.append('_token', document
                                                .querySelector(
                                                    'meta[name="csrf-token"]')
                                                .getAttribute('content'));
                                            formData.append('image_id', imgId);

                                            return fetch('/author/tinymce/upload', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
<<<<<<< HEAD
                                                            ).getAttribute(
=======
                                                        ).getAttribute(
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                                                            'content')
                                                },
                                                body: formData
                                            });
                                        })
                                        .then(response => response.json())
                                        .then(result => {
                                            if (result.status === 'success' || result
                                                .location) {
                                                // Tìm placeholder trong editor
                                                const placeholders = tinymce
                                                    .activeEditor.getBody()
                                                    .querySelectorAll(
                                                        `img[data-paste-id="${imgId}"]`
<<<<<<< HEAD
                                                        );
=======
                                                    );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                                                placeholders.forEach(placeholder => {
                                                    // Lưu lại các thuộc tính kích thước và style
                                                    const width = placeholder
                                                        .getAttribute('width');
                                                    const height = placeholder
                                                        .getAttribute('height');
                                                    const style = placeholder
                                                        .getAttribute('style');

                                                    // Cập nhật src của placeholder
                                                    placeholder.setAttribute(
                                                        'src', result
                                                        .location);
                                                    placeholder.setAttribute(
                                                        'data-mce-src',
                                                        result.location);
                                                    placeholder.setAttribute(
                                                        'data-moderated',
                                                        'true');
                                                    placeholder.setAttribute(
                                                        'moderated', 'true');
                                                    placeholder.classList
                                                        .remove(
                                                            'waiting-moderation'
<<<<<<< HEAD
                                                            );
=======
                                                        );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14

                                                    // Khôi phục các thuộc tính kích thước và style
                                                    if (width) placeholder
                                                        .setAttribute('width',
                                                            width);
                                                    if (height) placeholder
                                                        .setAttribute('height',
                                                            height);
                                                    if (style) placeholder
                                                        .setAttribute('style',
                                                            style);

                                                    // Đảm bảo ảnh hiển thị đúng
                                                    placeholder.style.display =
                                                        'inline-block';
                                                    placeholder.style
                                                        .verticalAlign =
                                                        'middle';

                                                    // Lưu vào danh sách ảnh đã kiểm duyệt
                                                    window._premoderatedImages =
                                                        window
                                                        ._premoderatedImages ||
                                                        {};
                                                    window._premoderatedImages[
                                                            result.location] =
                                                        true;
                                                });
                                            } else if (result.blocked === true || result
                                                .status === 'error') {
                                                // Xóa placeholder nếu ảnh bị chặn
                                                const placeholders = tinymce
                                                    .activeEditor.getBody()
                                                    .querySelectorAll(
                                                        `img[data-paste-id="${imgId}"]`
<<<<<<< HEAD
                                                        );
=======
                                                    );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                                                placeholders.forEach(placeholder => {
                                                    if (placeholder
                                                        .parentNode) {
                                                        placeholder.parentNode
                                                            .removeChild(
                                                                placeholder);
                                                    }
                                                });

                                                // Hiển thị thông báo lỗi
                                                let errorMessage =
                                                    'Hình ảnh không vượt qua kiểm duyệt';
                                                if (result.reason) {
                                                    if (typeof result.reason ===
                                                        'object') {
                                                        try {
                                                            errorMessage = Object
                                                                .values(result.reason)
                                                                .join(', ');
                                                        } catch (e) {
                                                            errorMessage = JSON
                                                                .stringify(result
                                                                    .reason);
                                                        }
                                                    } else {
                                                        errorMessage = String(result
                                                            .reason);
                                                    }
                                                } else if (result.message) {
                                                    errorMessage = result.message;
                                                }

                                                tinymce.activeEditor.notificationManager
                                                    .open({
                                                        text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                            errorMessage,
                                                        type: 'error',
                                                        timeout: 5000
                                                    });
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi kiểm duyệt ảnh:', error);
                                            // Xóa placeholder nếu có lỗi
                                            const placeholders = tinymce.activeEditor
                                                .getBody().querySelectorAll(
                                                    `img[data-paste-id="${imgId}"]`);
                                            placeholders.forEach(placeholder => {
                                                if (placeholder.parentNode) {
                                                    placeholder.parentNode
                                                        .removeChild(
                                                            placeholder);
                                                }
                                            });
                                        });
                                };
                                newImg.onerror = function() {
                                    console.error('Không thể tải ảnh:', originalSrc);
                                };
                                newImg.src = originalSrc;
                            }, 100);
                        }
                    });
                }

                // Xử lý lần cuối để đảm bảo không có khoảng cách không mong muốn
                // Tìm tất cả các thẻ p chứa ảnh
                const imgParagraphs = div.querySelectorAll('p > img:only-child');
                imgParagraphs.forEach(img => {
                    const p = img.parentNode;
                    if (p) {
                        // Đặt style cho thẻ p chứa ảnh
                        p.style.margin = '0';
                        p.style.padding = '0';
                        p.style.lineHeight = '1';
                    }
                });

                // Xóa các khoảng trắng thừa giữa các thẻ p
                const allParagraphs = div.querySelectorAll('p');
                allParagraphs.forEach(p => {
                    // Xóa các khoảng trắng ở đầu và cuối nội dung
                    if (p.firstChild && p.firstChild.nodeType === 3) {
                        p.firstChild.textContent = p.firstChild.textContent.trimStart();
                    }
                    if (p.lastChild && p.lastChild.nodeType === 3) {
                        p.lastChild.textContent = p.lastChild.textContent.trimEnd();
                    }
                });

                args.content = div.innerHTML;
                console.log('Đã xử lý paste_preprocess, nội dung mới:', args.content);
            },

            paste_postprocess: function(plugin, args) {
                console.log('paste_postprocess event', args);

                // Xử lý đặc biệt cho trường hợp paste cả ảnh và text
                const node = args.node;

                // Tìm tất cả các thẻ p có chứa cả ảnh và text
                const mixedParagraphs = Array.from(node.querySelectorAll('p')).filter(p => {
                    const hasImage = p.querySelector('img') !== null;
                    const hasText = Array.from(p.childNodes).some(n =>
                        n.nodeType === 3 && n.textContent.trim() !== '');
                    return hasImage && hasText;
                });

                console.log('Tìm thấy ' + mixedParagraphs.length + ' thẻ p có chứa cả ảnh và text');

                // Xử lý từng thẻ p có chứa cả ảnh và text
                mixedParagraphs.forEach(p => {
                    // Tạo một mảng chứa các node mới
                    const newNodes = [];

                    // Tạo thẻ p mới cho nội dung trước ảnh đầu tiên
                    let currentTextP = document.createElement('p');
                    newNodes.push(currentTextP);

                    // Duyệt qua từng node con của thẻ p
                    Array.from(p.childNodes).forEach(child => {
                        if (child.nodeType === 1 && child.tagName === 'IMG') {
                            // Nếu gặp ảnh, tạo thẻ p mới chỉ chứa ảnh
                            const imgP = document.createElement('p');
                            imgP.style.margin = '0';
                            imgP.style.padding = '0';
                            imgP.style.lineHeight = '1';

                            // Sao chép ảnh vào thẻ p mới
                            const imgClone = child.cloneNode(true);
                            imgP.appendChild(imgClone);
                            newNodes.push(imgP);

                            // Tạo thẻ p mới cho nội dung sau ảnh
                            currentTextP = document.createElement('p');
                            newNodes.push(currentTextP);
                        } else {
                            // Nếu không phải ảnh, thêm vào thẻ p hiện tại
                            currentTextP.appendChild(child.cloneNode(true));
                        }
                    });

                    // Xóa các thẻ p trống
                    const nonEmptyNodes = newNodes.filter(n => {
                        const content = n.innerHTML.trim();
                        return content !== '' && content !== '&nbsp;' && content !== '<br>' &&
                            content !== '<br />';
                    });

                    // Thay thế thẻ p gốc bằng các node mới
                    if (nonEmptyNodes.length > 0 && p.parentNode) {
                        // Chèn node đầu tiên vào vị trí của p
                        p.parentNode.replaceChild(nonEmptyNodes[0], p);

                        // Chèn các node còn lại sau node đầu tiên
                        let prevNode = nonEmptyNodes[0];
                        for (let i = 1; i < nonEmptyNodes.length; i++) {
                            if (prevNode.nextSibling) {
                                p.parentNode.insertBefore(nonEmptyNodes[i], prevNode.nextSibling);
                            } else {
                                p.parentNode.appendChild(nonEmptyNodes[i]);
                            }
                            prevNode = nonEmptyNodes[i];
                        }
                    }
                });

                // Xử lý các thẻ p chứa ảnh
                const imgParagraphs = node.querySelectorAll('p > img:only-child');
                imgParagraphs.forEach(img => {
                    const p = img.parentNode;
                    if (p) {
                        p.style.margin = '0';
                        p.style.padding = '0';
                        p.style.lineHeight = '1';
                    }
                });
            },

            setup: function(editor) {
                // Thêm sự kiện sau khi paste để xử lý cấu trúc HTML
                // Sự kiện khi nội dung thay đổi
                editor.on('change', function(e) {
                    // Xử lý đặc biệt cho trường hợp có ảnh trong nội dung
                    const content = editor.getContent();
                    if (content.includes('<img')) {
                        // Tạo một div tạm thời để xử lý nội dung
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = content;

                        // Xử lý các thẻ p chứa ảnh
                        const imgParagraphs = tempDiv.querySelectorAll('p > img:only-child');
                        let contentChanged = false;

                        imgParagraphs.forEach(img => {
                            const p = img.parentNode;
                            if (p) {
                                if (p.style.margin !== '0px' || p.style.padding !== '0px' || p
                                    .style.lineHeight !== '1') {
                                    p.style.margin = '0';
                                    p.style.padding = '0';
                                    p.style.lineHeight = '1';
                                    contentChanged = true;
                                }
                            }
                        });

                        // Nếu nội dung đã thay đổi, cập nhật lại editor
                        if (contentChanged) {
                            // Lưu vị trí con trỏ hiện tại
                            const bookmark = editor.selection.getBookmark();

                            // Cập nhật nội dung của editor
                            editor.setContent(tempDiv.innerHTML);

                            // Khôi phục vị trí con trỏ
                            editor.selection.moveToBookmark(bookmark);
                        }
                    }
                });

                editor.on('PastePostProcess', function(e) {
                    console.log('PastePostProcess event', e);

                    // Xử lý đặc biệt cho trường hợp paste cả ảnh và text
                    setTimeout(function() {
                        // Lấy toàn bộ nội dung của editor
                        const content = editor.getContent();

                        // Tạo một div tạm thời để xử lý nội dung
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = content;

                        // Tìm tất cả các thẻ p có chứa cả ảnh và text
                        const mixedParagraphs = Array.from(tempDiv.querySelectorAll('p'))
                            .filter(p => {
                                const hasImage = p.querySelector('img') !== null;
                                const hasText = Array.from(p.childNodes).some(n =>
                                    n.nodeType === 3 && n.textContent.trim() !== '');
                                return hasImage && hasText;
                            });

                        console.log('Tìm thấy ' + mixedParagraphs.length +
                            ' thẻ p có chứa cả ảnh và text');

                        let contentChanged = false;

                        // Xử lý từng thẻ p có chứa cả ảnh và text
                        mixedParagraphs.forEach(p => {
                            // Tạo một mảng chứa các node mới
                            const newNodes = [];

                            // Tạo thẻ p mới cho nội dung trước ảnh đầu tiên
                            let currentTextP = document.createElement('p');
                            newNodes.push(currentTextP);

                            // Duyệt qua từng node con của thẻ p
                            Array.from(p.childNodes).forEach(child => {
                                if (child.nodeType === 1 && child.tagName ===
                                    'IMG') {
                                    // Nếu gặp ảnh, tạo thẻ p mới chỉ chứa ảnh
                                    const imgP = document.createElement('p');
                                    imgP.style.margin = '0';
                                    imgP.style.padding = '0';
                                    imgP.style.lineHeight = '1';

                                    // Sao chép ảnh vào thẻ p mới
                                    const imgClone = child.cloneNode(true);
                                    imgP.appendChild(imgClone);
                                    newNodes.push(imgP);

                                    // Tạo thẻ p mới cho nội dung sau ảnh
                                    currentTextP = document.createElement('p');
                                    newNodes.push(currentTextP);

                                    contentChanged = true;
                                } else {
                                    // Nếu không phải ảnh, thêm vào thẻ p hiện tại
                                    currentTextP.appendChild(child.cloneNode(
                                        true));
                                }
                            });

                            // Xóa các thẻ p trống
                            const nonEmptyNodes = newNodes.filter(n => {
                                const content = n.innerHTML.trim();
                                return content !== '' && content !== '&nbsp;' &&
                                    content !== '<br>' && content !== '<br />';
                            });

                            // Thay thế thẻ p gốc bằng các node mới
                            if (nonEmptyNodes.length > 0 && p.parentNode) {
                                // Chèn node đầu tiên vào vị trí của p
                                p.parentNode.replaceChild(nonEmptyNodes[0], p);

                                // Chèn các node còn lại sau node đầu tiên
                                let prevNode = nonEmptyNodes[0];
                                for (let i = 1; i < nonEmptyNodes.length; i++) {
                                    if (prevNode.nextSibling) {
                                        p.parentNode.insertBefore(nonEmptyNodes[i],
                                            prevNode.nextSibling);
                                    } else {
                                        p.parentNode.appendChild(nonEmptyNodes[i]);
                                    }
                                    prevNode = nonEmptyNodes[i];
                                }
                            }
                        });

                        // Xử lý các thẻ p chứa ảnh
                        const imgParagraphs = tempDiv.querySelectorAll('p > img:only-child');
                        imgParagraphs.forEach(img => {
                            const p = img.parentNode;
                            if (p) {
                                p.style.margin = '0';
                                p.style.padding = '0';
                                p.style.lineHeight = '1';
                                contentChanged = true;
                            }
                        });

                        // Nếu nội dung đã thay đổi, cập nhật lại editor
                        if (contentChanged) {
                            // Cập nhật nội dung của editor
                            editor.setContent(tempDiv.innerHTML);
                            console.log('Đã cập nhật nội dung của editor');
                        }
                    }, 100);
                });


                function needsModeration(img) {
                    // Luôn yêu cầu kiểm duyệt trừ khi đã được đánh dấu rõ ràng
                    if (img.hasAttribute('data-moderated') ||
                        img.hasAttribute('data-no-remoderation') ||
                        img.hasAttribute('moderated')) {
                        return false;
                    }

                    // Kiểm tra xem ảnh có trong danh sách đã kiểm duyệt trước đó không
                    const src = img.getAttribute('src');
                    if (src && window._premoderatedImages && window._premoderatedImages[src]) {
                        console.log('Ảnh đã được kiểm duyệt trước đó:', src);
                        // Đánh dấu lại để không cần kiểm duyệt nữa
                        img.setAttribute('data-moderated', 'true');
                        img.setAttribute('data-no-remoderation', 'true');
                        img.setAttribute('moderated', 'true');
                        img._moderationState = {
                            moderated: true,
                            noRemoderation: true,
                        };
                        return false;
                    }

                    // Ngay cả ảnh từ storage cũng cần kiểm duyệt nếu chưa được đánh dấu
                    return true;
                }

                function scanAndProcessImages() {
                    // Kiểm tra nếu tự động kiểm duyệt bị vô hiệu hóa (trang edit) và không phải do người dùng khởi tạo
                    if (window.disableAutoImageModeration && !window.userInitiatedImageScan) {
                        console.log(
                            'Tự động kiểm duyệt bị vô hiệu hóa và không phải do người dùng khởi tạo, bỏ qua việc quét ảnh'
<<<<<<< HEAD
                            );
=======
                        );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                        return;
                    }

                    if (window.checkingImages) {
                        console.log('Đang trong quá trình kiểm duyệt, bỏ qua');
                        return;
                    }

                    // Nếu đang import từ Word, bỏ qua việc quét
                    if (window.importingFromWord) {
                        console.log('Đang import từ Word, bỏ qua việc kiểm duyệt');
                        return;
                    }

                    // Nếu đang có ảnh đang tải lên qua upload handler, bỏ qua việc quét
                    if (window.uploadingImages && window.uploadingImages > 0) {
                        console.log('Đang có ' + window.uploadingImages +
<<<<<<< HEAD
                        ' ảnh đang tải lên, bỏ qua việc quét');
=======
                            ' ảnh đang tải lên, bỏ qua việc quét');
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                        return;
                    }

                    // Khởi tạo danh sách ảnh đã kiểm duyệt nếu chưa tồn tại
                    window._premoderatedImages = window._premoderatedImages || {};

                    // Lấy tất cả ảnh chưa được kiểm duyệt (kể cả ảnh từ storage)
                    const images = editor.getBody().querySelectorAll(
                        'img:not([data-moderated]):not([moderated])'
                    );

                    if (images.length === 0) {
                        return;
                    }

                    // Kiểm tra xem có ảnh nào đang trong quá trình tải lên không
                    const uploading = editor.getBody().querySelectorAll(
                        'img[data-uploading="true"], img.uploading-via-handler');
                    if (uploading.length > 0) {
                        console.log('Có ' + uploading.length +
                            ' ảnh đang được xử lý bởi images_upload_handler, bỏ qua việc kiểm duyệt');
                        return;
                    }

                    // Lọc ảnh cần kiểm duyệt (bỏ qua những ảnh đã nằm trong danh sách)
                    const imagesToModerate = [...images].filter(img => {
                        const src = img.getAttribute('src');
                        if (src && window._premoderatedImages && window._premoderatedImages[src]) {
                            console.log('Bỏ qua ảnh đã kiểm duyệt trước đó:', src);
                            img.setAttribute('data-moderated', 'true');
                            img.setAttribute('data-no-remoderation', 'true');
                            img.setAttribute('moderated', 'true');
                            img._moderationState = {
                                moderated: true,
                                noRemoderation: true,
                            };
                            return false;
                        }
                        // Bỏ qua ảnh blob đang chờ xử lý bởi images_upload_handler
                        if (src && src.startsWith('blob:') &&
                            (img.classList.contains('waiting-upload') ||
                                img.classList.contains('uploading-via-handler') ||
                                img.hasAttribute('data-uploading'))) {
                            console.log('Bỏ qua ảnh blob đang chờ xử lý:', src);
                            return false;
                        }
                        return true;
                    });

                    if (imagesToModerate.length === 0) {
                        console.log('Không có ảnh nào cần kiểm duyệt sau khi lọc');
                        return;
                    }

                    console.log('Tìm thấy ' + imagesToModerate.length + ' hình ảnh cần kiểm duyệt trong DOM');
                    window.checkingImages = true;

                    const notification = editor.notificationManager.open({
                        text: 'Đang kiểm duyệt ' + imagesToModerate.length + ' hình ảnh...',
                        type: 'info',
                        progressBar: true,
                        timeout: false,
                    });

                    let processedImages = 0;
                    const totalImages = imagesToModerate.length;

                    imagesToModerate.forEach(function(img) {
                        const originalSrc = img.getAttribute('src');

                        // Đánh dấu ảnh đang được kiểm duyệt
                        img.classList.add('moderating');
                        img.classList.remove('waiting-moderation');
                        img.style.opacity = '0.5';
                        img.style.border = '2px dashed #ccc';

                        if (originalSrc.startsWith('data:image')) {
                            // Xử lý ảnh dạng data URL
                            fetch(originalSrc)
                                .then(res => res.blob())
                                .then(blob => {
                                    const formData = new FormData();
                                    const fileName = `pasted-image-${Date.now()}.png`;
                                    const file = new File([blob], fileName, {
                                        type: blob.type
                                    });

                                    formData.append('file', file);
                                    formData.append('_token', document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'));

                                    // Lưu trữ ID của ảnh để cập nhật sau khi kiểm duyệt
                                    formData.append('image_id', img.getAttribute('data-paste-id') ||
                                        '');

                                    return fetch('/author/tinymce/upload', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content'),
                                        },
                                        body: formData,
                                    });
                                })
                                .then(response => response.json())
                                .then(result => {
                                    processedImages++;
                                    notification.progressBar.value(processedImages / totalImages *
                                        100);

                                    img.classList.remove('moderating');
                                    img.style.opacity = '1';
                                    img.style.border = 'none';

                                    if (result.blocked === true) {
                                        console.log('Hình ảnh bị chặn:', result);

                                        if (result.url && !window.blockedImages.includes(result
                                                .url)) {
                                            window.blockedImages.push(result.url);
                                        }

                                        if (document.getElementById('has_blocked_images')) {
                                            document.getElementById('has_blocked_images').value =
                                                'true';
                                        }

                                        if (img.parentNode) {
                                            img.parentNode.removeChild(img);
                                        }

                                        let errorMessage = 'Vi phạm quy định nội dung';

                                        if (result.reasons && Array.isArray(result.reasons)) {
                                            errorMessage = result.reasons.join(', ');
                                        } else if (result.reasons) {
                                            errorMessage = typeof result.reasons === 'object' ?
                                                JSON.stringify(result.reasons) : String(result
                                                    .reasons);
                                        } else if (result.reason) {
                                            if (typeof result.reason === 'object') {
                                                try {
                                                    errorMessage = Object.values(result.reason)
                                                        .join(', ');
                                                } catch (e) {
                                                    errorMessage = JSON.stringify(result.reason);
                                                }
                                            } else {
                                                errorMessage = String(result.reason);
                                            }
                                        } else if (result.message) {
                                            errorMessage = result.message;
                                        }

                                        setTimeout(function() {
                                            var notification = tinymce.activeEditor
                                                .notificationManager.open({
                                                    text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                        errorMessage,
                                                    type: 'error',
                                                    timeout: 5000,
                                                });

                                            setTimeout(function() {
                                                notification.close();
                                            }, 5000);
                                        }, 200);
                                    } else if (result.status === 'error' || !result.location) {
                                        console.log('Lỗi kiểm duyệt:', result);

                                        if (result.url && !window.blockedImages.includes(result
                                                .url)) {
                                            window.blockedImages.push(result.url);
                                        }

                                        if (document.getElementById('has_blocked_images')) {
                                            document.getElementById('has_blocked_images').value =
                                                'true';
                                        }

                                        if (img.parentNode) {
                                            img.parentNode.removeChild(img);
                                        }

                                        let errorMessage = 'Lỗi kiểm duyệt';
                                        if (result.message) {
                                            errorMessage = typeof result.message === 'object' ?
                                                JSON.stringify(result.message) : String(result
                                                    .message);
                                        }

                                        setTimeout(function() {
                                            var notification = tinymce.activeEditor
                                                .notificationManager.open({
                                                    text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                        errorMessage,
                                                    type: 'error',
                                                    timeout: 5000,
                                                });

                                            setTimeout(function() {
                                                notification.close();
                                            }, 5000);
                                        }, 200);
                                    } else {
                                        // Ảnh đã vượt qua kiểm duyệt
                                        if (result.location) {
                                            // Cập nhật src của ảnh
                                            img.setAttribute('src', result.location);

                                            // Cập nhật data-mce-src để ảnh hiển thị được trong TinyMCE
                                            img.setAttribute('data-mce-src', result.location);

                                            // Cập nhật tất cả các ảnh có cùng ID trong editor
                                            const pasteId = img.getAttribute('data-paste-id');
                                            if (pasteId) {
                                                const sameIdImages = editor.getBody()
                                                    .querySelectorAll(
                                                        `img[data-paste-id="${pasteId}"]`);
                                                if (sameIdImages.length > 0) {
                                                    sameIdImages.forEach(sameImg => {
                                                        if (sameImg !== img) {
                                                            sameImg.setAttribute('src',
                                                                result.location);
                                                            sameImg.setAttribute(
                                                                'data-mce-src', result
                                                                .location);
                                                            sameImg.setAttribute(
                                                                'data-moderated', 'true'
<<<<<<< HEAD
                                                                );
=======
                                                            );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                                                            sameImg.setAttribute(
                                                                'data-no-remoderation',
                                                                'true');
                                                            sameImg.setAttribute(
                                                                'moderated', 'true');
                                                            sameImg.style.opacity = '1';
                                                            sameImg.style.border = 'none';
                                                            sameImg.classList.remove(
                                                                'moderating');
                                                        }
                                                    });
                                                }
                                            }
                                        }

                                        // Đánh dấu ảnh đã được kiểm duyệt
                                        img.setAttribute('data-moderated', 'true');
                                        img.setAttribute('data-no-remoderation', 'true');
                                        img.setAttribute('moderated', 'true');

                                        img._moderationState = {
                                            moderated: true,
                                            noRemoderation: true,
                                        };

                                        // Lưu vào danh sách ảnh đã kiểm duyệt
                                        if (result.location) {
                                            window._premoderatedImages = window
                                                ._premoderatedImages || {};
                                            window._premoderatedImages[result.location] = true;
                                        }
                                    }

                                    if (processedImages === totalImages) {
                                        notification.close();
                                        window.checkingImages = false;
                                        // Đặt lại trạng thái khởi tạo quét từ người dùng sau khi hoàn thành
                                        setTimeout(() => {
                                            window.userInitiatedImageScan = false;
                                        }, 500);
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi xử lý ảnh:', error);
                                    processedImages++;
                                    notification.progressBar.value(processedImages / totalImages *
                                        100);

                                    img.classList.remove('moderating');
                                    img.style.opacity = '1';
                                    img.style.border = 'none';

                                    if (processedImages === totalImages) {
                                        notification.close();
                                        window.checkingImages = false;
                                        // Đặt lại trạng thái khởi tạo quét từ người dùng sau khi hoàn thành
                                        setTimeout(() => {
                                            window.userInitiatedImageScan = false;
                                        }, 500);
                                    }
                                });
                        } else if (originalSrc.startsWith('http') || originalSrc.startsWith('/')) {
                            // Xử lý ảnh từ URL (bao gồm cả URL tương đối)
                            let imageUrl = originalSrc;
                            if (originalSrc.startsWith('/')) {
                                imageUrl = window.location.origin + originalSrc;
                            }

                            fetch('/api/force-enhanced-moderation', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content'),
                                    },
                                    body: JSON.stringify({
                                        image_url: imageUrl
                                    }),
                                })
                                .then(response => response.json())
                                .then(result => {
                                    processedImages++;
                                    notification.progressBar.value(processedImages / totalImages *
                                        100);

                                    img.classList.remove('moderating');
                                    img.style.opacity = '1';
                                    img.style.border = 'none';

                                    if (result.status === 'success' && result.violation_level ===
                                        'none') {
                                        if (result.location) {
                                            img.setAttribute('src', result.location);
                                        }
                                        img.setAttribute('data-moderated', 'true');
                                        img.setAttribute('data-no-remoderation', 'true');
                                        img.setAttribute('moderated', 'true');

                                        img._moderationState = {
                                            moderated: true,
                                            noRemoderation: true,
                                        };

                                        if (img.hasAttribute('data-mce-src')) {
                                            img.removeAttribute('data-mce-src');
                                        }
                                    } else {
                                        console.log('Vi phạm kiểm duyệt:', result);

                                        if (!window.blockedImages.includes(originalSrc)) {
                                            window.blockedImages.push(originalSrc);
                                        }

                                        if (document.getElementById('has_blocked_images')) {
                                            document.getElementById('has_blocked_images').value =
                                                'true';
                                        }

                                        if (img.parentNode) {
                                            img.parentNode.removeChild(img);
                                        }

                                        let errorMessage = 'Vi phạm quy định nội dung';

                                        if (result.reason) {
                                            if (typeof result.reason === 'object') {
                                                try {
                                                    errorMessage = Object.values(result.reason)
                                                        .join(', ');
                                                } catch (e) {
                                                    errorMessage = JSON.stringify(result.reason);
                                                }
                                            } else {
                                                errorMessage = String(result.reason);
                                            }
                                        } else if (result.message) {
                                            errorMessage = typeof result.message === 'object' ?
                                                JSON.stringify(result.message) : String(result
                                                    .message);
                                        }

                                        setTimeout(function() {
                                            var notification = tinymce.activeEditor
                                                .notificationManager.open({
                                                    text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                        errorMessage,
                                                    type: 'error',
                                                    timeout: 5000,
                                                });

                                            setTimeout(function() {
                                                notification.close();
                                            }, 5000);
                                        }, 200);
                                    }

                                    if (processedImages === totalImages) {
                                        notification.close();
                                        window.checkingImages = false;
                                        // Đặt lại trạng thái khởi tạo quét từ người dùng sau khi hoàn thành
                                        setTimeout(() => {
                                            window.userInitiatedImageScan = false;
                                        }, 500);
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi kiểm duyệt:', error);
                                    processedImages++;
                                    notification.progressBar.value(processedImages / totalImages *
                                        100);

                                    img.classList.remove('moderating');
                                    img.style.opacity = '1';
                                    img.style.border = 'none';

                                    if (processedImages === totalImages) {
                                        notification.close();
                                        window.checkingImages = false;
                                        // Đặt lại trạng thái khởi tạo quét từ người dùng sau khi hoàn thành
                                        setTimeout(() => {
                                            window.userInitiatedImageScan = false;
                                        }, 500);
                                    }
                                });
                        } else {
                            processedImages++;
                            notification.progressBar.value(processedImages / totalImages * 100);

                            img.classList.remove('moderating');
                            img.style.opacity = '1';
                            img.style.border = 'none';

                            if (processedImages === totalImages) {
                                notification.close();
                                window.checkingImages = false;
                                // Đặt lại trạng thái khởi tạo quét từ người dùng sau khi hoàn thành
                                setTimeout(() => {
                                    window.userInitiatedImageScan = false;
                                }, 500);
                            }
                        }
                    });
                }

                // Thêm xử lý sự kiện Word Import
                editor.on('WordImported', function(e) {
                    console.log('Word đã được import xong');

                    // Đánh dấu tất cả ảnh từ Word như đã được tải lên
                    setTimeout(function() {
                        try {
                            const wordImages = editor.getBody().querySelectorAll(
                                'img:not([data-moderated])');
                            console.log('Tìm thấy ' + wordImages.length +
                                ' ảnh từ Word cần đánh dấu');

                            // Đánh dấu lại tất cả ảnh từ Word
                            wordImages.forEach(img => {
                                if (img.src && img.src.indexOf('blob:') !== 0) {
                                    // Đánh dấu ảnh từ Word đã được tải lên
                                    img.setAttribute('data-moderated', 'true');
                                    img.setAttribute('data-no-remoderation', 'true');
                                    img.setAttribute('moderated', 'true');
                                    img.setAttribute('data-from-word', 'true');
                                    img.classList.add('imported-from-word');
                                    img.classList.remove('waiting-moderation');

                                    // Đánh dấu trong global để không kiểm duyệt lại
                                    window._premoderatedImages = window
                                        ._premoderatedImages || {};
                                    window._premoderatedImages[img.src] = true;

                                    console.log('Đã đánh dấu ảnh từ Word:', img.src);
                                }
                            });

                            // Hiển thị thông báo import thành công
                            tinymce.activeEditor.notificationManager.open({
                                text: 'Đã nhập nội dung từ Word thành công!',
                                type: 'success',
                                timeout: 3000,
                            });
                        } catch (e) {
                            console.error('Lỗi khi đánh dấu ảnh từ Word:', e);
                        }

                        // Đánh dấu quá trình import đã kết thúc
                        window._importingFromWord = false;
                        window.importingFromWord = false;
                    }, 500);
                });

                // Thêm xử lý đặc biệt cho sự kiện PastePreProcess khi paste từ Word
                editor.on('PastePreProcess', function(e) {
                    console.log('PastePreProcess event');

                    // Đánh dấu là người dùng đã khởi tạo quét ảnh
                    window.userInitiatedImageScan = true;

                    // Kiểm tra nếu paste từ Word
                    if (e.content && e.content.indexOf('urn:schemas-microsoft-com:office:') !== -1) {
                        console.log('Phát hiện paste từ Word');
                        window._pastingFromWord = true;
                    }
                });

                // Xử lý sau khi paste nội dung từ Word
                editor.on('PastePostProcess', function(e) {
                    console.log('PastePostProcess event');

                    // Đánh dấu là người dùng đã khởi tạo quét ảnh
                    window.userInitiatedImageScan = true;

                    if (window._pastingFromWord) {
                        console.log('Đang xử lý nội dung paste từ Word');

                        setTimeout(function() {
                            try {
                                const wordImages = editor.getBody().querySelectorAll(
                                    'img:not([data-moderated])');
                                console.log('Tìm thấy ' + wordImages.length +
                                    ' ảnh từ paste Word cần đánh dấu');

                                wordImages.forEach(img => {
                                    if (img.src && img.src.indexOf('blob:') !== 0) {
                                        // Đánh dấu ảnh đã được tải lên
                                        img.setAttribute('data-moderated', 'true');
                                        img.setAttribute('data-no-remoderation',
<<<<<<< HEAD
                                        'true');
=======
                                            'true');
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                                        img.setAttribute('moderated', 'true');
                                        img.classList.add('pasted-from-word');
                                        img.classList.remove('waiting-moderation');

                                        // Đánh dấu trong global để không kiểm duyệt lại
                                        window._premoderatedImages = window
                                            ._premoderatedImages || {};
                                        window._premoderatedImages[img.src] = true;
                                    }
                                });
                            } catch (e) {
                                console.error('Lỗi khi đánh dấu ảnh paste từ Word:', e);
                            }

                            window._pastingFromWord = false;
                        }, 300);
                    }
                });

                editor.on('init', function() {
                    console.log('TinyMCE đã khởi tạo');

                    window.blockedImages = window.blockedImages || [];
                    window.checkingImages = false;

                    if (document.getElementById('articleForm')) {
                        if (!document.getElementById('has_blocked_images')) {
                            const blockedImagesInput = document.createElement('input');
                            blockedImagesInput.type = 'hidden';
                            blockedImagesInput.id = 'has_blocked_images';
                            blockedImagesInput.name = 'has_blocked_images';
                            blockedImagesInput.value = 'false';
                            document.getElementById('articleForm').appendChild(blockedImagesInput);
                        }
                    }

                    editor.getBody().addEventListener('paste', function(e) {
                        console.log('Bắt được sự kiện DOM paste');
                    }, true);

                    editor.getBody().addEventListener('dblclick', function(e) {
                        const target = e.target;
                        if (target.nodeName === 'IMG') {

                            if (!target.hasAttribute('data-no-remoderation')) {
                                target.setAttribute('data-no-remoderation', 'true');
                            }
                            if (!target.hasAttribute('data-moderated')) {
                                target.setAttribute('data-moderated', 'true');
                            }
                            if (!target.hasAttribute('moderated')) {
                                target.setAttribute('moderated', 'true');
                            }

                            target._moderationState = {
                                moderated: true,
                                noRemoderation: true,
                            };
                        }
                    }, true);

                    editor.getBody().addEventListener('mousedown', function(e) {

                        const allImages = editor.getBody().querySelectorAll('img');
                        allImages.forEach(img => {
                            if (img.complete && img.naturalWidth > 0) {

                                if (!img.hasAttribute('data-no-remoderation')) {
                                    img.setAttribute('data-no-remoderation', 'true');
                                }
                                if (!img.hasAttribute('data-moderated')) {
                                    img.setAttribute('data-moderated', 'true');
                                }
                                if (!img.hasAttribute('moderated')) {
                                    img.setAttribute('moderated', 'true');
                                }
                            }
                        });
                    });

                    const originalSetAttrib = editor.dom.setAttrib;
                    editor.dom.setAttrib = function(elm, name, value) {
                        if ((name === 'data-moderated' || name === 'data-no-remoderation' ||
                                name === 'moderated') && value === null && elm._moderationState) {
                            return elm;
                        }
                        return originalSetAttrib.call(this, elm, name, value);
                    };

                    const observer = new MutationObserver(function(mutations) {
                        let hasNewImages = false;

                        mutations.forEach(mutation => {
                            if (mutation.type === 'childList' && mutation.addedNodes
                                .length > 0) {
                                for (let i = 0; i < mutation.addedNodes.length; i++) {
                                    const node = mutation.addedNodes[i];

                                    if (node.nodeName === 'IMG') {
                                        if (!needsModeration(node)) {
                                            continue;
                                        }

                                        node.setAttribute('data-need-moderation',
                                            'true');
                                        hasNewImages = true;
                                    } else if (node.querySelectorAll) {
                                        const images = node.querySelectorAll('img');
                                        if (images.length > 0) {
                                            images.forEach(img => {
                                                if (!needsModeration(img)) {
                                                    return;
                                                }

                                                img.setAttribute(
                                                    'data-need-moderation',
                                                    'true');
                                                hasNewImages = true;
                                            });
                                        }
                                    }
                                }
                            } else if (mutation.type === 'attributes' && mutation.target
                                .nodeName === 'IMG') {
                                const img = mutation.target;
                                if (img._moderationState && img._moderationState
                                    .moderated) {
                                    if (!img.hasAttribute('data-moderated')) {
                                        img.setAttribute('data-moderated', 'true');
                                    }
                                    if (!img.hasAttribute('data-no-remoderation')) {
                                        img.setAttribute('data-no-remoderation',
                                            'true');
                                    }
                                    if (!img.hasAttribute('moderated')) {
                                        img.setAttribute('moderated', 'true');
                                    }
                                }
                            }
                        });

                        if (hasNewImages && !window.checkingImages) {
                            setTimeout(scanAndProcessImages, 100);
                        }
                    });

                    observer.observe(editor.getBody(), {
                        childList: true,
                        subtree: true,
                        attributes: true,
                        attributeFilter: ['src'],
                    });

                    setInterval(function() {
                        if (!window.checkingImages) {
                            const images = editor.getBody().querySelectorAll(
                                'img:not([data-moderated]):not([data-need-moderation])');
                            if (images.length > 0) {
                                console.log('Tìm thấy ' + images.length +
                                    ' hình ảnh chưa được xử lý trong lần quét định kỳ');

                                // Nếu tìm thấy ảnh chưa được kiểm duyệt, đánh dấu là người dùng đã khởi tạo quét
                                window.userInitiatedImageScan = true;

                                let needModeration = false;

                                images.forEach(img => {
                                    const src = img.getAttribute('src');
                                    if (src && (src.includes('/storage/uploads/') || src
                                            .includes('/uploads/'))) {
                                        img.setAttribute('data-moderated', 'true');
                                    } else {
                                        img.setAttribute('data-need-moderation',
                                            'true');
                                        needModeration = true;
                                    }
                                });

                                if (needModeration) {
                                    console.log('Tìm thấy ' + images.length +
                                        ' hình ảnh chưa được xử lý trong lần quét định kỳ');
                                    scanAndProcessImages();
                                }
                            }
                        }
                    }, 2000);
                });

                editor.on('PastePreProcess', function(e) {
                    console.log('PastePreProcess event');
                });

                editor.on('PastePostProcess', function(e) {
                    console.log('PastePostProcess event');
                });

                editor.on('paste', function(e) {
                    console.log('Paste event đã được kích hoạt');
                    // Đánh dấu là người dùng đã khởi tạo quét ảnh
                    window.userInitiatedImageScan = true;
                });

                editor.on('BeforeSetContent', function(e) {
                    console.log('BeforeSetContent event');

                    if (e.content && e.content.indexOf('<img') >= 0) {
                        const div = document.createElement('div');
                        div.innerHTML = e.content;

                        const images = div.querySelectorAll('img');
                        if (images.length > 0) {
                            console.log('Đánh dấu ' + images.length +
                                ' hình ảnh trong BeforeSetContent');

                            images.forEach(img => {
                                // Kiểm tra xem ảnh đã kiểm duyệt chưa
                                const src = img.getAttribute('src');
                                if (src && window._premoderatedImages && window
                                    ._premoderatedImages[src]) {
                                    console.log('Ảnh đã kiểm duyệt sẵn, đánh dấu ngay lập tức:',
                                        src);
                                    img.setAttribute('data-moderated', 'true');
                                    img.setAttribute('data-no-remoderation', 'true');
                                    img.setAttribute('moderated', 'true');
                                    if (!img.hasAttribute('_moderationState')) {
                                        img._moderationState = {
                                            moderated: true,
                                            noRemoderation: true,
                                        };
                                    }
                                } else {
                                    // Chỉ đánh dấu cần kiểm duyệt nếu chưa được kiểm duyệt
                                    img.setAttribute('data-need-moderation', 'true');
                                }

                                if (img.hasAttribute('data-mce-src')) {
                                    img.removeAttribute('data-mce-src');
                                }
                                if (img.hasAttribute('data-mce-selected')) {
                                    img.removeAttribute('data-mce-selected');
                                }
                                if (img.hasAttribute('data-mce-object')) {
                                    img.removeAttribute('data-mce-object');
                                }

                                img.setAttribute('onload',
                                    'this.removeAttribute("data-mce-src")');
                            });

                            e.content = div.innerHTML;
                        }
                    }
                });

                editor.on('SetContent', function(e) {
                    console.log('SetContent event');

                    // Nếu đang import từ Word, đợi dài hơn trước khi xử lý
                    const timeoutDuration = window.importingFromWord ? 1000 : 100;

                    // Kiểm tra và đánh dấu ảnh đã xử lý nếu đang import từ Word
                    if (window.importingFromWord) {
                        console.log('Đang xử lý nội dung từ Word trong SetContent');

                        setTimeout(function() {
                            try {
                                // Đánh dấu tất cả ảnh từ Word như đã được kiểm duyệt
                                const wordImages = editor.getBody().querySelectorAll(
                                    'img:not([data-moderated])');
                                if (wordImages.length > 0) {
                                    console.log('Đánh dấu ' + wordImages.length +
                                        ' ảnh đã import từ Word');

                                    wordImages.forEach(img => {
                                        if (!img.hasAttribute('moderated')) {
                                            img.setAttribute('data-moderated', 'true');
                                            img.setAttribute('data-no-remoderation',
                                                'true');
                                            img.setAttribute('moderated', 'true');
                                            img.setAttribute('data-from-word', 'true');
                                            img.classList.add('imported-from-word');

                                            // Đánh dấu trong global để không kiểm duyệt lại
                                            const src = img.getAttribute('src');
                                            if (src) {
                                                window._premoderatedImages = window
                                                    ._premoderatedImages || {};
                                                window._premoderatedImages[src] = true;
                                            }
                                        }
                                    });
                                }

                                // Đánh dấu quá trình import Word đã kết thúc
                                window.importingFromWord = false;
                            } catch (e) {
                                console.error('Lỗi khi xử lý ảnh từ Word trong SetContent:', e);
                                window.importingFromWord = false;
                            }
                        }, 800);
                    }

                    // Đặt timeout ngắn để đảm bảo DOM đã được cập nhật
                    setTimeout(function() {
                        // Đánh dấu lại các ảnh đã kiểm duyệt
                        if (window._premoderatedImages) {
                            const allImages = editor.getBody().querySelectorAll('img');
                            let markedCount = 0;

                            allImages.forEach(img => {
                                const src = img.getAttribute('src');
                                if (src && window._premoderatedImages[src]) {
                                    img.setAttribute('data-moderated', 'true');
                                    img.setAttribute('data-no-remoderation', 'true');
                                    img.setAttribute('moderated', 'true');
                                    img._moderationState = {
                                        moderated: true,
                                        noRemoderation: true,
                                    };
                                    markedCount++;
                                }
                            });

                            if (markedCount > 0) {
                                console.log(`Đã đánh dấu ${markedCount} ảnh đã kiểm duyệt sẵn`);
                            }
                        }

                        // Không quét ảnh nếu đang import từ Word hoặc trang edit (và không phải do người dùng khởi tạo)
                        if (!window.importingFromWord && (!window.disableAutoImageModeration ||
                                window.userInitiatedImageScan)) {
                            // Sau đó mới quét các ảnh cần kiểm duyệt
                            scanAndProcessImages();
                        } else if (window.disableAutoImageModeration && !window
                            .userInitiatedImageScan) {
                            console.log(
                                'Tự động kiểm duyệt bị vô hiệu hóa (trang edit) và không phải do người dùng khởi tạo, bỏ qua quét ảnh'
<<<<<<< HEAD
                                );
=======
                            );
>>>>>>> 222f9abf2b4ff93daa12201b35094085be9e8e14
                        }
                    }, timeoutDuration);
                });

                editor.on('BeforeUpload', function(e) {
                    console.log('BeforeUpload event', e);

                    if (e.target && !e.target.getAttribute('data-moderated')) {
                        console.log('Ngăn chặn tự động upload cho ảnh chưa kiểm duyệt');
                        return false;
                    }
                });

                editor.on('submit', function() {
                    console.log('Submit event');
                    removeBlockedImagesFromContent(editor);
                });

                // Thêm xử lý sự kiện kéo thả (drop)
                editor.on('drop', function(e) {
                    console.log('Drop event được kích hoạt');
                    // Đánh dấu là người dùng đã khởi tạo quét ảnh
                    window.userInitiatedImageScan = true;
                });
            },

            images_upload_handler: function(blobInfo, progress) {
                console.log('TinyMCE images_upload_handler được gọi', blobInfo);

                // Đánh dấu là đang trong quá trình upload để tránh xử lý trùng lặp
                window.uploadingImages = window.uploadingImages || 0;
                window.uploadingImages++;

                // Đánh dấu đây là quét do người dùng khởi tạo
                window.userInitiatedImageScan = true;

                return new Promise((resolve, reject) => {
                    if (!blobInfo || typeof blobInfo.blob !== 'function') {
                        console.error('blobInfo không hợp lệ:', blobInfo);
                        window.uploadingImages--;
                        reject({
                            message: 'Dữ liệu hình ảnh không hợp lệ',
                            remove: false
                        });
                        return;
                    }

                    // Tạo một hình ảnh tạm để đánh dấu là đang được xử lý
                    try {
                        // Tìm tất cả các ảnh blob trong editor mà có thể liên quan đến upload này
                        const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                            'img[src^="blob:"]');
                        editorImages.forEach(img => {
                            // Đánh dấu các ảnh blob là đang chờ xử lý bởi upload handler
                            img.classList.add('waiting-upload');
                            img.classList.add('uploading-via-handler');
                            img.setAttribute('data-uploading', 'true');
                        });
                    } catch (e) {
                        console.error('Lỗi khi đánh dấu ảnh đang upload:', e);
                    }

                    // Chỉ hiển thị notification chung nếu không có uploadingNotification
                    if (!window.uploadingNotification) {
                        window.uploadingNotification = tinymce.activeEditor.notificationManager.open({
                            text: 'Đang tải lên và kiểm duyệt hình ảnh...',
                            type: 'info',
                            progressBar: true,
                            closeButton: false,
                        });
                    }

                    var formData = new FormData();
                    try {
                        var blob = blobInfo.blob();
                        var filename = blobInfo.filename();

                        console.log('Bắt đầu tải lên:', filename, 'type:', blob.type, 'size:', blob
                            .size);

                        formData.append('file', blob, filename);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'));
                    } catch (e) {
                        console.error('Lỗi khi xử lý blob:', e);
                        if (window.uploadingNotification && window.uploadingImages <= 1) {
                            window.uploadingNotification.close();
                            window.uploadingNotification = null;
                        }
                        window.uploadingImages--;

                        // Xóa lớp đánh dấu trên các ảnh
                        try {
                            const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                                'img.uploading-via-handler');
                            editorImages.forEach(img => {
                                img.classList.remove('waiting-upload');
                                img.classList.remove('uploading-via-handler');
                                img.removeAttribute('data-uploading');
                            });
                        } catch (ex) {
                            console.error('Lỗi khi xóa đánh dấu ảnh:', ex);
                        }

                        reject({
                            message: 'Lỗi khi xử lý hình ảnh: ' + e.message,
                            remove: true
                        });
                        return;
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    xhr.open('POST', '/author/tinymce/upload');

                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector(
                        'meta[name="csrf-token"]').getAttribute('content'));

                    xhr.upload.onprogress = function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = (e.loaded / e.total) * 100;
                            if (window.uploadingNotification) {
                                window.uploadingNotification.progressBar.value(percentComplete);
                            }

                            if (progress) {
                                progress(percentComplete);
                            }
                        }
                    };

                    xhr.onload = function() {
                        window.uploadingImages--;
                        if (window.uploadingImages <= 0) {
                            if (window.uploadingNotification) {
                                window.uploadingNotification.close();
                                window.uploadingNotification = null;
                            }
                            window.uploadingImages = 0;
                        }

                        // Xóa lớp đánh dấu trên các ảnh sau khi upload xong
                        try {
                            const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                                'img.uploading-via-handler');
                            editorImages.forEach(img => {
                                img.classList.remove('waiting-upload');
                                img.classList.remove('uploading-via-handler');
                                img.removeAttribute('data-uploading');
                            });
                        } catch (ex) {
                            console.error('Lỗi khi xóa đánh dấu ảnh:', ex);
                        }

                        console.log('Phản hồi từ server:', xhr.status, xhr.responseText);

                        if (xhr.status < 200 || xhr.status >= 300) {
                            console.error('Lỗi HTTP:', xhr.status, xhr.statusText);

                            var errorMessage = 'Lỗi HTTP: ' + xhr.status;
                            try {
                                var errorJson = JSON.parse(xhr.responseText);
                                if (errorJson && errorJson.message) {
                                    errorMessage += ' - ' + errorJson.message;
                                }
                            } catch (e) {
                                if (xhr.responseText && xhr.responseText.length < 100) {
                                    errorMessage += ' - ' + xhr.responseText;
                                }
                            }

                            setTimeout(function() {
                                var notification = tinymce.activeEditor
                                    .notificationManager.open({
                                        text: 'Không thể tải lên hình ảnh: ' +
                                            errorMessage,
                                        type: 'error',
                                        timeout: 5000,
                                    });

                                setTimeout(function() {
                                    notification.close();
                                }, 5000);
                            }, 200);

                            reject({
                                message: errorMessage,
                                remove: true
                            });
                            return;
                        }

                        try {
                            var json = JSON.parse(xhr.responseText);
                            console.log('Kết quả từ server trong images_upload_handler:', json);

                            // Thêm log để kiểm tra kết quả kiểm duyệt
                            console.log('Trạng thái kiểm duyệt:',
                                json.blocked === true ? 'Hình ảnh bị chặn' :
                                'Hình ảnh được chấp nhận');

                            if (json.blocked === true) {
                                console.log('Hình ảnh bị chặn từ server:', json);

                                if (json.url && !window.blockedImages.includes(json.url)) {
                                    window.blockedImages.push(json.url);
                                }

                                if (document.getElementById('has_blocked_images')) {
                                    document.getElementById('has_blocked_images').value = 'true';
                                }

                                let errorMessage = 'Vi phạm quy định nội dung';

                                if (json.reasons && Array.isArray(json.reasons)) {
                                    errorMessage = json.reasons.join(', ');
                                } else if (json.reasons) {
                                    errorMessage = typeof json.reasons === 'object' ?
                                        JSON.stringify(json.reasons) : String(json.reasons);
                                } else if (json.reason) {
                                    if (typeof json.reason === 'object') {
                                        try {
                                            errorMessage = Object.values(json.reason).join(', ');
                                        } catch (e) {
                                            errorMessage = JSON.stringify(json.reason);
                                        }
                                    } else {
                                        errorMessage = String(json.reason);
                                    }
                                } else if (json.message) {
                                    errorMessage = json.message;
                                }

                                setTimeout(function() {
                                    var notification = tinymce.activeEditor
                                        .notificationManager.open({
                                            text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                errorMessage,
                                            type: 'error',
                                            timeout: 5000,
                                        });

                                    setTimeout(function() {
                                        notification.close();
                                    }, 5000);
                                }, 200);

                                reject({
                                    message: 'Hình ảnh không vượt qua kiểm duyệt',
                                    remove: true
                                });
                                return;
                            }

                            if (!json.location) {
                                console.error('Không tìm thấy URL hình ảnh trong phản hồi:', json);
                                reject({
                                    message: 'Phản hồi thiếu URL hình ảnh',
                                    remove: true
                                });
                                return;
                            }

                            console.log('Ảnh đã được tải lên thành công, đường dẫn: ' + json
                                .location);

                            // Tạo một hình ảnh ẩn để thêm các thuộc tính kiểm duyệt trước khi thêm vào editor
                            const tempImg = document.createElement('img');
                            tempImg.src = json.location;
                            tempImg.setAttribute('data-moderated', 'true');
                            tempImg.setAttribute('data-no-remoderation', 'true');
                            tempImg.setAttribute('moderated', 'true');

                            // Đánh dấu trong global để đảm bảo không phải kiểm duyệt lại
                            window._premoderatedImages = window._premoderatedImages || {};
                            window._premoderatedImages[json.location] = true;

                            console.log('Đã đánh dấu ảnh đã kiểm duyệt trước khi chèn vào editor:',
                                json.location);

                            setTimeout(function() {
                                var notification = tinymce.activeEditor
                                    .notificationManager.open({
                                        text: 'Hình ảnh đã được tải lên thành công!',
                                        type: 'success',
                                        timeout: 3000,
                                    });

                                setTimeout(function() {
                                    notification.close();
                                }, 3000);
                            }, 200);

                            resolve(json.location);

                            setTimeout(function() {
                                try {
                                    console.log('Tìm kiếm ảnh có src=' + json.location);
                                    const allImages = tinymce.activeEditor.getBody()
                                        .querySelectorAll('img');

                                    allImages.forEach(function(img) {
                                        const imgSrc = img.getAttribute('src');

                                        if (imgSrc === json.location ||
                                            (imgSrc && json.location && imgSrc
                                                .includes(json.location.split('/')
                                                    .pop()))) {
                                            console.log(
                                                'Tìm thấy và đánh dấu ảnh đã được kiểm duyệt:',
                                                imgSrc);

                                            img.setAttribute('data-moderated',
                                                'true');
                                            img.setAttribute('data-no-remoderation',
                                                'true');
                                            img.setAttribute('moderated',
                                                'true'); // Thuộc tính tùy chỉnh

                                            img._moderationState = {
                                                moderated: true,
                                                noRemoderation: true,
                                            };

                                            if (img.hasAttribute('data-mce-src')) {
                                                img.removeAttribute('data-mce-src');
                                            }
                                            if (img.hasAttribute(
                                                    'data-mce-selected')) {
                                                img.removeAttribute(
                                                    'data-mce-selected');
                                            }
                                            if (img.hasAttribute(
                                                    'data-mce-object')) {
                                                img.removeAttribute(
                                                    'data-mce-object');
                                            }
                                            if (img.hasAttribute(
                                                    'data-mce-placeholder')) {
                                                img.removeAttribute(
                                                    'data-mce-placeholder');
                                            }
                                            if (img.hasAttribute(
                                                    'data-need-moderation')) {
                                                img.removeAttribute(
                                                    'data-need-moderation');
                                            }
                                        }
                                    });
                                } catch (e) {
                                    console.error('Lỗi khi đánh dấu ảnh đã kiểm duyệt:', e);
                                }
                            }, 100);

                        } catch (e) {
                            console.error('Lỗi parse JSON:', e, xhr.responseText);
                            reject({
                                message: 'Lỗi xử lý phản hồi từ server',
                                remove: true
                            });
                        }
                    };

                    xhr.onerror = function() {
                        window.uploadingImages--;
                        if (window.uploadingImages <= 0) {
                            if (window.uploadingNotification) {
                                window.uploadingNotification.close();
                                window.uploadingNotification = null;
                            }
                            window.uploadingImages = 0;
                        }

                        // Xóa lớp đánh dấu trên các ảnh khi có lỗi
                        try {
                            const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                                'img.uploading-via-handler');
                            editorImages.forEach(img => {
                                img.classList.remove('waiting-upload');
                                img.classList.remove('uploading-via-handler');
                                img.removeAttribute('data-uploading');
                            });
                        } catch (ex) {
                            console.error('Lỗi khi xóa đánh dấu ảnh:', ex);
                        }

                        console.error('Lỗi kết nối');
                        reject({
                            message: 'Lỗi kết nối mạng',
                            remove: true
                        });
                    };

                    xhr.onabort = function() {
                        window.uploadingImages--;
                        if (window.uploadingImages <= 0) {
                            if (window.uploadingNotification) {
                                window.uploadingNotification.close();
                                window.uploadingNotification = null;
                            }
                            window.uploadingImages = 0;
                        }

                        // Xóa lớp đánh dấu trên các ảnh khi hủy
                        try {
                            const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                                'img.uploading-via-handler');
                            editorImages.forEach(img => {
                                img.classList.remove('waiting-upload');
                                img.classList.remove('uploading-via-handler');
                                img.removeAttribute('data-uploading');
                            });
                        } catch (ex) {
                            console.error('Lỗi khi xóa đánh dấu ảnh:', ex);
                        }

                        reject({
                            message: 'Việc tải lên bị hủy',
                            remove: true
                        });
                    };

                    xhr.ontimeout = function() {
                        window.uploadingImages--;
                        if (window.uploadingImages <= 0) {
                            if (window.uploadingNotification) {
                                window.uploadingNotification.close();
                                window.uploadingNotification = null;
                            }
                            window.uploadingImages = 0;
                        }

                        // Xóa lớp đánh dấu trên các ảnh khi hết hạn
                        try {
                            const editorImages = tinymce.activeEditor.getBody().querySelectorAll(
                                'img.uploading-via-handler');
                            editorImages.forEach(img => {
                                img.classList.remove('waiting-upload');
                                img.classList.remove('uploading-via-handler');
                                img.removeAttribute('data-uploading');
                            });
                        } catch (ex) {
                            console.error('Lỗi khi xóa đánh dấu ảnh:', ex);
                        }

                        reject({
                            message: 'Thao tác tải lên đã hết thời gian',
                            remove: true
                        });
                    };

                    xhr.send(formData);
                });
            },
            // tinydrive_token_provider: 'ae65bcdf52b2b51143d84279e4393ca0129cad1971389dce9efe133d92adeb88',

            mobile: {
                plugins: ' preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link math media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker editimage help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable footnotes mergetags autocorrect typography advtemplate',
            },
            menu: {
                tc: {
                    title: 'Comments',
                    items: 'addcomment showcomments deleteallconversations',
                },
            },
            typography_rules: [
                'common/punctuation/quote',
                'en-US/dash/main',
                'common/nbsp/afterParagraphMark',
                'common/nbsp/afterSectionMark',
                'common/nbsp/afterShortWord',
                'common/nbsp/beforeShortLastNumber',
                'common/nbsp/beforeShortLastWord',
                'common/nbsp/dpi',
                'common/punctuation/apostrophe',
                'common/space/delBeforePunctuation',
                'common/space/afterComma',
                'common/space/afterColon',
                'common/space/afterExclamationMark',
                'common/space/afterQuestionMark',
                'common/space/afterSemicolon',
                'common/space/beforeBracket',
                'common/space/bracket',
                'common/space/delBeforeDot',
                'common/space/squareBracket',
                'common/number/mathSigns',
                'common/number/times',
                'common/number/fraction',
                'common/symbols/arrow',
                'common/symbols/cf',
                'common/symbols/copy',
                'common/punctuation/delDoublePunctuation',
                'common/punctuation/hellip',
            ],
            typography_ignore: ['code'],

            images_file_types: 'jpeg,jpg,jpe,jfi,jif,jfif,png,gif,bmp,webp',
            file_picker_types: 'file image media',
            block_unsupported_drop: false,
            file_picker_callback: function(cb, value, meta) {
                return new Promise(function(resolve, reject) {
                    // Đánh dấu đây là quét do người dùng khởi tạo
                    window.userInitiatedImageScan = true;

                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');

                    if (meta.filetype === 'image') {
                        input.setAttribute('accept', 'image/*');
                    } else if (meta.filetype === 'media') {
                        input.setAttribute('accept', 'video/*,audio/*');
                    } else {
                        input.setAttribute('accept', '*/*');
                    }

                    input.onchange = function() {
                        var file = this.files[0];

                        if (!file) {
                            console.log('Không có file được chọn');
                            return;
                        }

                        console.log('File đã chọn:', file.name, 'type:', file.type);

                        if (!file.type.match(/^image\//)) {
                            tinymce.activeEditor.notificationManager.open({
                                text: 'Vui lòng chọn file hình ảnh',
                                type: 'error',
                                timeout: 3000,
                            });
                            return;
                        }

                        var notification = tinymce.activeEditor.notificationManager.open({
                            text: 'Đang tải lên và kiểm duyệt hình ảnh...',
                            type: 'info',
                            progressBar: true,
                            closeButton: false,
                        });

                        var formData = new FormData();
                        formData.append('file', file);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'));

                        var xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '/author/tinymce/upload');

                        xhr.upload.onprogress = function(e) {
                            if (e.lengthComputable) {
                                notification.progressBar.value(e.loaded / e.total * 100);
                            }
                        };

                        xhr.onload = function() {
                            if (xhr.status < 200 || xhr.status >= 300) {
                                notification.close();
                                console.error('Lỗi HTTP:', xhr.status, xhr.statusText);
                                setTimeout(function() {
                                    tinymce.activeEditor.notificationManager.open({
                                        text: 'Lỗi khi tải lên: ' + xhr
                                            .statusText,
                                        type: 'error',
                                        timeout: 3000,
                                    });
                                }, 200);
                                return;
                            }

                            try {
                                var json = JSON.parse(xhr.responseText);
                                console.log('Kết quả upload:', json);

                                notification.close();

                                if (!json || typeof json.location !== 'string') {
                                    console.error('Phản hồi không hợp lệ:', json);
                                    setTimeout(function() {
                                        tinymce.activeEditor.notificationManager.open({
                                            text: 'Phản hồi từ server không hợp lệ',
                                            type: 'error',
                                            timeout: 3000,
                                        });
                                    }, 200);
                                    return;
                                }

                                if (json.blocked) {
                                    console.log('Ảnh bị chặn:', json);

                                    if (json.url && !window.blockedImages.includes(json.url)) {
                                        window.blockedImages.push(json.url);
                                    }

                                    if (document.getElementById('has_blocked_images')) {
                                        document.getElementById('has_blocked_images').value =
                                            'true';
                                    }

                                    let errorMessage = 'Vi phạm quy định nội dung';

                                    if (json.reasons && Array.isArray(json.reasons)) {
                                        errorMessage = json.reasons.join(', ');
                                    } else if (json.reasons) {
                                        errorMessage = typeof json.reasons === 'object' ?
                                            JSON.stringify(json.reasons) : String(json.reasons);
                                    } else if (json.reason) {
                                        if (typeof json.reason === 'object') {
                                            try {
                                                errorMessage = Object.values(json.reason).join(
                                                    ', ');
                                            } catch (e) {
                                                errorMessage = JSON.stringify(json.reason);
                                            }
                                        } else {
                                            errorMessage = String(json.reason);
                                        }
                                    } else if (json.message) {
                                        errorMessage = json.message;
                                    }

                                    setTimeout(function() {
                                        var notification = tinymce.activeEditor
                                            .notificationManager.open({
                                                text: 'Hình ảnh không vượt qua kiểm duyệt: ' +
                                                    errorMessage,
                                                type: 'error',
                                                timeout: 5000,
                                            });

                                        setTimeout(function() {
                                            notification.close();
                                        }, 5000);
                                    }, 200);
                                    return;
                                }

                                console.log('Ảnh đã được tải lên thành công, đường dẫn: ' + json
                                    .location);

                                // Tạo một hình ảnh ẩn để thêm các thuộc tính kiểm duyệt trước khi thêm vào editor
                                const tempImg = document.createElement('img');
                                tempImg.src = json.location;
                                tempImg.setAttribute('data-moderated', 'true');
                                tempImg.setAttribute('data-no-remoderation', 'true');
                                tempImg.setAttribute('moderated', 'true');

                                // Đánh dấu trong global để đảm bảo không phải kiểm duyệt lại
                                window._premoderatedImages = window._premoderatedImages || {};
                                window._premoderatedImages[json.location] = true;

                                console.log(
                                    'Đã đánh dấu ảnh đã kiểm duyệt trước khi chèn vào editor:',
                                    json.location);

                                setTimeout(function() {
                                    var notification = tinymce.activeEditor
                                        .notificationManager.open({
                                            text: 'Hình ảnh đã được tải lên thành công!',
                                            type: 'success',
                                            timeout: 3000,
                                        });

                                    setTimeout(function() {
                                        notification.close();
                                    }, 3000);
                                }, 200);

                                cb(json.location, {
                                    title: file.name
                                });
                                resolve();

                                setTimeout(function() {
                                    const newImages = tinymce.activeEditor.getBody()
                                        .querySelectorAll('img[src="' + json.location +
                                            '"]:not([data-moderated])');
                                    newImages.forEach(function(img) {
                                        console.log(
                                            'Đánh dấu ảnh đã được kiểm duyệt:',
                                            json.location);
                                        img.setAttribute('data-moderated',
                                            'true');
                                        img.setAttribute('data-no-remoderation',
                                            'true');
                                        img.setAttribute('moderated',
                                            'true');

                                        img._moderationState = {
                                            moderated: true,
                                            noRemoderation: true,
                                        };

                                        // Thêm vào danh sách ảnh đã kiểm duyệt toàn cục
                                        window._premoderatedImages = window
                                            ._premoderatedImages || {};
                                        window._premoderatedImages[json
                                            .location] = true;

                                        if (img.hasAttribute('data-mce-src')) {
                                            img.removeAttribute('data-mce-src');
                                        }
                                        if (img.hasAttribute(
                                                'data-mce-selected')) {
                                            img.removeAttribute(
                                                'data-mce-selected');
                                        }
                                        if (img.hasAttribute(
                                                'data-mce-object')) {
                                            img.removeAttribute(
                                                'data-mce-object');
                                        }
                                        if (img.hasAttribute(
                                                'data-mce-placeholder')) {
                                            img.removeAttribute(
                                                'data-mce-placeholder');
                                        }
                                        if (img.hasAttribute(
                                                'data-need-moderation')) {
                                            img.removeAttribute(
                                                'data-need-moderation');
                                        }
                                    });
                                }, 100);

                            } catch (e) {
                                notification.close();
                                console.error('Lỗi parse JSON:', e, xhr.responseText);
                                setTimeout(function() {
                                    tinymce.activeEditor.notificationManager.open({
                                        text: 'Lỗi xử lý phản hồi từ server',
                                        type: 'error',
                                        timeout: 3000,
                                    });
                                }, 200);
                            }
                        };

                        xhr.onerror = function() {
                            notification.close();
                            console.error('Lỗi kết nối khi upload');
                            setTimeout(function() {
                                tinymce.activeEditor.notificationManager.open({
                                    text: 'Lỗi kết nối khi tải lên hình ảnh',
                                    type: 'error',
                                    timeout: 3000,
                                });
                            }, 200);
                        };

                        xhr.send(formData);
                    };

                    input.click();
                });
            },

            importcss_append: true,
            spellchecker_ignore_list: ['Ephox', 'Moxiecode', 'tinymce', 'TinyMCE'],
            tinycomments_mode: 'embedded',
            a11y_advanced_options: true,
            autocorrect_capitalize: true,
            mergetags_list: [{
                    title: 'Client',
                    menu: [{
                            value: 'Client.LastCallDate',
                            title: 'Call date',
                        },
                        {
                            value: 'Client.Name',
                            title: 'Client name',
                        },
                    ],
                },
                {
                    title: 'Proposal',
                    menu: [{
                        value: 'Proposal.SubmissionDate',
                        title: 'Submission date',
                    }, ],
                },
                {
                    value: 'Consultant',
                    title: 'Consultant',
                },
                {
                    value: 'Salutation',
                    title: 'Salutation',
                },
            ],
            // For revision history plugin

            exportpdf_converter_options: {
                'format': 'Letter',
                'margin_top': '1in',
                'margin_right': '1in',
                'margin_bottom': '1in',
                'margin_left': '1in',
            },
            exportword_converter_options: {
                'document': {
                    'size': 'Letter',
                },
            },
            importword_converter_options: {
                'formatting': {
                    'styles': 'inline',
                    'resets': 'inline',
                    'defaults': 'inline',
                },
                'import_word_file_callback': function(file, done) {
                    // Đánh dấu rằng đang nhập từ Word để xử lý đặc biệt
                    window._importingFromWord = true;
                    window.importingFromWord = true;
                    console.log('Bắt đầu import từ Word');

                    // Hiển thị thông báo khi bắt đầu import
                    var importNotification = tinymce.activeEditor.notificationManager.open({
                        text: 'Đang nhập và xử lý nội dung từ Word...',
                        type: 'info',
                        progressBar: true,
                        timeout: 5000,
                    });

                    // Đặt timeout để đóng thông báo
                    setTimeout(function() {
                        importNotification.close();
                    }, 5000);

                    return true; // Cho phép quá trình import tiếp tục
                },
            },
            /*
            The following settings require more configuration than shown here.
            For information on configuring the mentions plugin, see:
            https://www.tiny.cloud/docs/tinymce/latest/mentions/.
            */

        });
</script>



<script>
    setTimeout(function() {
        let error_message = document.querySelectorAll('.error_message');
        error_message.forEach(alert => alert.style.display = 'none');
    }, 5000);
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatarUpload');
        const avatarPreview = document.getElementById('avatarPreview');
        const widgetUserImage = document.querySelector('.widget-user-image');

        if (widgetUserImage) {
            // Click vào ảnh hoặc icon camera để mở dialog chọn file
            widgetUserImage.addEventListener('click', function() {
                avatarInput.click();
            });

            // Xử lý khi chọn file
            avatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData();
                    formData.append('image', this.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    // Hiển thị loading state
                    avatarPreview.style.opacity = '0.5';

                    fetch('{{ route("profile.upload-avatar") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật ảnh preview
                            avatarPreview.src = data.avatar_url;
                            // Hiển thị thông báo thành công
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.innerHTML = `
                                ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `;
                            document.querySelector('.box-body').insertBefore(alertDiv, document.querySelector('.edit-profile-toggle'));
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        // Hiển thị thông báo lỗi
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            ${error.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.querySelector('.box-body').insertBefore(alertDiv, document.querySelector('.edit-profile-toggle'));
                    })
                    .finally(() => {
                        // Reset loading state
                        avatarPreview.style.opacity = '1';
                    });
                }
            });
        }
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatarUpload');
        const avatarPreview = document.getElementById('avatarPreview');
        const widgetUserImage = document.querySelector('.widget-user-image');

        if (widgetUserImage) {
            // Click vào ảnh hoặc icon camera để mở dialog chọn file
            widgetUserImage.addEventListener('click', function() {
                avatarInput.click();
            });

            // Xử lý khi chọn file
            avatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData();
                    formData.append('image', this.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    // Hiển thị trạng thái loading (giảm opacity)
                    avatarPreview.style.opacity = '0.5';

                    fetch('{{ route('profile.upload-avatar') }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json()) // Chắc chắn là json
                        .then(data => {
                            console.log(data); // Log dữ liệu phản hồi từ server

                            if (data.success) {
                                // Cập nhật ảnh preview
                                avatarPreview.src = data.avatar_url;

                                // Hiển thị thông báo thành công
                                const alertDiv = document.createElement('div');
                                alertDiv.className =
                                    'alert alert-success alert-dismissible fade show';
                                alertDiv.innerHTML = `
                                         ${data.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    `;
                                document.querySelector('.box-body').prepend(alertDiv);
                            } else {
                                throw new Error(data.message); // Nếu không thành công, ném lỗi
                            }
                        })
                        .catch(error => {
                            // Hiển thị thông báo lỗi nếu có
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                            alertDiv.innerHTML = `
                                    ${error.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    `;                                                                      
                            document.querySelector('.box-body').prepend(alertDiv);
                        })
                        .finally(() => {
                            avatarPreview.style.opacity = '1'; // Reset trạng thái loading
                        });


                }
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const articleForm = document.querySelector('form[action*="articles"]');
        if (articleForm) {
            articleForm.addEventListener('submit', function(e) {
                if (typeof tinyMCE !== 'undefined') {
                    tinyMCE.triggerSave();
                }

                if (document.getElementById('has_blocked_images') &&
                    document.getElementById('has_blocked_images').value === 'true' &&
                    document.getElementById('confirmed_submit') &&
                    document.getElementById('confirmed_submit').value !== 'true' &&
                    window.blockedImages.length > 0) {

                    e.preventDefault();

                    if (confirm('Bài viết của bạn có ' + window.blockedImages.length +
                            ' hình ảnh không vượt qua kiểm duyệt và sẽ bị xóa khỏi nội dung. Bạn có muốn tiếp tục?'
                        )) {
                        if (typeof tinyMCE !== 'undefined') {
                            const editor = tinyMCE.get('content');
                            if (editor) {
                                removeBlockedImagesFromContent(editor);
                                editor.save();
                            }
                        }

                        if (window.blockedImages.length > 0) {
                            if (!document.getElementById('blocked_images_list')) {
                                const blockedImagesInput = document.createElement('input');
                                blockedImagesInput.type = 'hidden';
                                blockedImagesInput.name = 'blocked_images_list';
                                blockedImagesInput.id = 'blocked_images_list';
                                articleForm.appendChild(blockedImagesInput);
                            }

                            document.getElementById('blocked_images_list').value = JSON.stringify(window
                                .blockedImages);
                        }

                        document.getElementById('confirmed_submit').value = 'true';

                        this.submit();
                    }
                }
            });
        }

        if (articleForm) {
            if (!document.getElementById('blocked_images_list')) {
                const blockedImagesInput = document.createElement('input');
                blockedImagesInput.type = 'hidden';
                blockedImagesInput.name = 'blocked_images_list';
                blockedImagesInput.id = 'blocked_images_list';
                articleForm.appendChild(blockedImagesInput);
            }

            if (!document.getElementById('has_blocked_images')) {
                const hasBlockedImages = document.createElement('input');
                hasBlockedImages.type = 'hidden';
                hasBlockedImages.name = 'has_blocked_images';
                hasBlockedImages.id = 'has_blocked_images';
                hasBlockedImages.value = 'false';
                articleForm.appendChild(hasBlockedImages);
            }

            if (!document.getElementById('confirmed_submit')) {
                const confirmedSubmit = document.createElement('input');
                confirmedSubmit.type = 'hidden';
                confirmedSubmit.name = 'confirmed_submit';
                confirmedSubmit.id = 'confirmed_submit';
                confirmedSubmit.value = 'false';
                articleForm.appendChild(confirmedSubmit);
            }
        }
    });
</script>

<style>
    .widget-user-image {
        position: relative;
        width: 128px;
        height: 128px;
        margin: -64px auto 0;
        border: 3px solid #fff;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .widget-user-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .avatar-edit {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: rgba(255, 255, 255, 0.9);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
    }

    .avatar-edit i {
        color: #333;
        font-size: 16px;
    }

    .widget-user-header {
        position: relative;
        padding: 3rem 1rem;
        background-size: cover;
        background-position: center;
        text-align: center;
    }

    .widget-user-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .widget-user-username,
    .widget-user-desc {
        position: relative;
        z-index: 1;
        margin: 0;
    }

    .widget-user-username {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .widget-user-desc {
        font-size: 0.875rem;
        opacity: 0.9;
    }
</style>
