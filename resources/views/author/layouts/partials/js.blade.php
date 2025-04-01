<!-- Vendor JS -->
<script src="/admin/main/js/vendors.min.js"></script>
<script src="/admin/main/js/pages/chat-popup.js"></script>
<script src="/admin/main/../assets/icons/feather-icons/feather.min.js"></script>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    const fetchApi = import(
        'https://unpkg.com/@microsoft/fetch-event-source@2.0.1/lib/esm/index.js'
    ).then((module) => module.fetchEventSource);

    // This example stores the OpenAI API key in the client side integration. This is not recommended for any purpose.
    // Instead, an alternate method for retrieving the API key should be used.
    const openai_api_key = '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';
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    window.blockedImages = [];
    window.checkingImages = false;

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
            selector: 'textarea#full-featured',
            plugins: 'preview searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media table charmap pagebreak anchor insertdatetime advlist lists wordcount help formatpainter permanentpen charmap emoticons',
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
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',

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
                        }

                        if (el.tagName === 'P' || el.tagName === 'DIV') {
                            if (el.style.clear === 'none') el.style.removeProperty('clear');
                            if (el.style.float === 'none') el.style.removeProperty('float');
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

                const images = div.querySelectorAll('img');

                if (images.length > 0) {
                    console.log('Tìm thấy ' + images.length + ' hình ảnh trong nội dung paste');

                    [...images].forEach(img => {
                        if (img.src && (img.src.startsWith('http') || img.src.startsWith(
                                'data:image'))) {
                            const imgId = 'img-' + Date.now() + '-' + Math.floor(Math.random() * 10000);

                            img.setAttribute('data-need-moderation', 'true');
                            img.setAttribute('data-paste-id', imgId);

                            ['data-mce-src', 'data-mce-selected', 'data-mce-object',
                                'data-mce-placeholder', 'contenteditable', 'data-mce-resize',
                                'data-mce-bogus'
                            ].forEach(attr => {
                                if (img.hasAttribute(attr)) {
                                    img.removeAttribute(attr);
                                }
                            });

                            img.setAttribute('onload', 'this.removeAttribute("data-mce-src")');
                            img.classList.add('waiting-moderation');

                            if (img.parentNode && img.parentNode.tagName !== 'P' &&
                                img.parentNode.tagName !== 'DIV') {
                                const wrapper = document.createElement('p');
                                img.parentNode.replaceChild(wrapper, img);
                                wrapper.appendChild(img);
                            }
                        }
                    });
                }

                args.content = div.innerHTML;
                console.log('Đã xử lý paste_preprocess, nội dung mới:', args.content);
            },

            setup: function(editor) {

                function needsModeration(img) {
                    if (img.hasAttribute('data-moderated') ||
                        img.hasAttribute('data-no-remoderation') ||
                        img.hasAttribute('moderated')) {
                        return false;
                    }

                    const src = img.getAttribute('src');
                    if (src && (src.includes('/storage/uploads/') || src.includes('/uploads/'))) {
                        img.setAttribute('data-moderated', 'true');
                        img.setAttribute('data-no-remoderation', 'true');
                        img.setAttribute('moderated', 'true');
                        return false;
                    }

                    return true;
                }

                function scanAndProcessImages() {
                    if (window.checkingImages) {
                        return;
                    }

                    const images = editor.getBody().querySelectorAll(
                        'img[data-need-moderation="true"]:not([data-no-remoderation]):not([data-moderated]):not([moderated])'
                    );
                    if (images.length === 0) {
                        return;
                    }

                    console.log('Tìm thấy ' + images.length + ' hình ảnh cần kiểm duyệt trong DOM');
                    window.checkingImages = true;

                    const notification = editor.notificationManager.open({
                        text: 'Đang kiểm duyệt ' + images.length + ' hình ảnh...',
                        type: 'info',
                        progressBar: true,
                        timeout: false,
                        closeButton: false,
                    });

                    let processedImages = 0;
                    const totalImages = images.length;

                    [...images].forEach(function(img) {
                        const originalSrc = img.getAttribute('src');

                        if (originalSrc && (originalSrc.includes('/storage/uploads/') || originalSrc
                                .includes('/uploads/'))) {
                            console.log('Ảnh đã được tải lên từ server, không cần kiểm duyệt lại:',
                                originalSrc);
                            img.removeAttribute('data-need-moderation');
                            img.setAttribute('data-moderated', 'true');
                            img.setAttribute('data-no-remoderation', 'true');
                            img.setAttribute('moderated', 'true');

                            img._moderationState = {
                                moderated: true,
                                noRemoderation: true,
                            };

                            img.classList.remove('moderating');
                            img.classList.remove('waiting-moderation');
                            img.style.opacity = '1';
                            img.style.border = 'none';

                            processedImages++;
                            notification.progressBar.value(processedImages / totalImages * 100);

                            if (processedImages === totalImages) {
                                notification.close();
                                window.checkingImages = false;
                            }

                            return;
                        }

                        img.removeAttribute('data-need-moderation');

                        img.classList.add('moderating');
                        img.classList.remove('waiting-moderation');
                        img.style.opacity = '0.5';
                        img.style.border = '2px dashed #ccc';

                        if (originalSrc.startsWith('data:image')) {
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
                                    }

                                    if (processedImages === totalImages) {
                                        notification.close();
                                        window.checkingImages = false;
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
                                    }
                                });
                        } else if (originalSrc.startsWith('http')) {
                            fetch('/api/moderate/image-url', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content'),
                                    },
                                    body: JSON.stringify({
                                        image_url: originalSrc
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
                            }
                        }
                    });
                }

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
                });

                editor.on('BeforeSetContent', function(e) {
                    console.log('BeforeSetContent event');

                    if (e.content && e.content.indexOf('<img') >= 0) {
                        const div = document.createElement('div');
                        div.innerHTML = e.content;

                        const images = div.querySelectorAll('img:not([data-moderated])');
                        if (images.length > 0) {
                            console.log('Đánh dấu ' + images.length +
                                ' hình ảnh trong BeforeSetContent');

                            images.forEach(img => {
                                img.setAttribute('data-need-moderation', 'true');

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
                    setTimeout(scanAndProcessImages, 100);
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
            },

            images_upload_handler: function(blobInfo, progress) {
                console.log('TinyMCE images_upload_handler được gọi', blobInfo);

                var defaultHandling = false;

                return new Promise((resolve, reject) => {
                    if (!blobInfo || typeof blobInfo.blob !== 'function') {
                        console.error('blobInfo không hợp lệ:', blobInfo);
                        reject({
                            message: 'Dữ liệu hình ảnh không hợp lệ',
                            remove: false
                        });
                        return;
                    }

                    const notification = tinymce.activeEditor.notificationManager.open({
                        text: 'Đang tải lên hình ảnh...',
                        type: 'info',
                        progressBar: true,
                        closeButton: false,
                    });

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
                        notification.close();
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
                            notification.progressBar.value(percentComplete);

                            if (progress) {
                                progress(percentComplete);
                            }
                        }
                    };

                    xhr.onload = function() {
                        notification.close();

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
                                var notification = tinymce.activeEditor.notificationManager
                                    .open({
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

                            setTimeout(function() {
                                var notification = tinymce.activeEditor.notificationManager
                                    .open({
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

                                            img.onmousedown = function(e) {
                                                if (this.hasAttribute(
                                                        'data-moderated')) {
                                                    this.setAttribute(
                                                        'data-no-remoderation',
                                                        'true');
                                                }
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
                                message: 'Lỗi xử lý phản hồi: ' + e.message,
                                remove: true
                            });
                        }
                    };

                    xhr.onerror = function() {
                        notification.close();
                        console.error('Lỗi kết nối');
                        reject({
                            message: 'Lỗi kết nối mạng',
                            remove: true
                        });
                    };

                    xhr.onabort = function() {
                        notification.close();
                        reject({
                            message: 'Việc tải lên bị hủy',
                            remove: true
                        });
                    };

                    xhr.ontimeout = function() {
                        notification.close();
                        reject({
                            message: 'Thao tác tải lên đã hết thời gian',
                            remove: true
                        });
                    };

                    xhr.send(formData);
                });
            },

            automatic_uploads: true,
            images_upload_credentials: false,
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
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | importword exportword exportpdf  | blocks fontsizeinput | bold italic | align numlist bullist | link image | table math media pageembed | lineheight  outdent indent | strikethrough forecolor backcolor formatpainter removeformat | charmap emoticons checklist | code fullscreen preview | save print | pagebreak anchor codesample footnotes mergetags | addtemplate inserttemplate | addcomment showcomments | ltr rtl casechange | spellcheckdialog a11ycheck', // Note: if a toolbar item requires a plugin, the item will not present in the toolbar if the plugin is not also loaded.
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
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
                                        img.setAttribute('moderated', 'true');

                                        img._moderationState = {
                                            moderated: true,
                                            noRemoderation: true,
                                        };

                                        img.onmousedown = function(e) {
                                            if (this.hasAttribute(
                                                    'data-moderated')) {
                                                this.setAttribute(
                                                    'data-no-remoderation',
                                                    'true');
                                            }
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
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            spellchecker_ignore_list: ['Ephox', 'Moxiecode', 'tinymce', 'TinyMCE'],
            tinycomments_mode: 'embedded',
            content_style: '.mymention{ color: gray; } .moderation-blocked { color: red; border: 1px solid red; padding: 5px; display: inline-block; } .moderation-error { color: orange; border: 1px solid orange; padding: 5px; display: inline-block; }',
            contextmenu: 'link image editimage table configurepermanentpen',
            a11y_advanced_options: true,
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
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
    }, 155000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUpload = document.getElementById('avatarUpload');
        const imagePreview = document.getElementById('avatarPreview');

        if (document.querySelector('.avatar-edit')) {
            document.querySelector('.avatar-edit').addEventListener('click', function() {
                imageUpload.click();
            });

            imageUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData();
                    formData.append('image', this.files[0]);
                    formData.append('_token', "{{ csrf_token() }}");

                    fetch("{{ route('profile.upload-avatar') }}", {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error uploading the image!');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                imagePreview.src = data.image_url;
                            } else {
                                alert('Error uploading the image.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while uploading the image.');
                        });

                    this.value = '';
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Interaction stats chart
        const interactionData = @json($interactionData ?? []);
        
        const options = {
            series: [{
                name: 'Lượt xem',
                data: interactionData.views ?? []
            }, {
                name: 'Bình luận',
                data: interactionData.comments ?? []
            }, {
                name: 'Lượt thích',
                data: interactionData.likes ?? []
            }],
            chart: {
                type: 'area',
                height: 250,
                stacked: false,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            xaxis: {
                categories: interactionData.dates ?? ['Không có dữ liệu'],
                labels: {
                    rotate: -45,
                    rotateAlways: false
                }
            },
            colors: ['#0090e7', '#00d97e', '#f7b731'],
            tooltip: {
                shared: true
            }
        };
        
        if (!interactionData || !interactionData.dates || interactionData.dates.length === 0) {
            document.getElementById('interaction-stats-chart').innerHTML = 
                '<div class="text-center p-4">Không có dữ liệu tương tác</div>';
        } else {
            const chart = new ApexCharts(document.querySelector("#interaction-stats-chart"), options);
            chart.render();
        }
    });
</script>

