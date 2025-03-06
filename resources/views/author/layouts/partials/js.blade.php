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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script referrerpolicy="origin"
        src="https://cdn.tiny.cloud/1/z5nmbwpgzi1mqfjo2czz0cu8h05tmwnkumfhvwkcnr16tn3a/tinymce/7/tinymce.min.js"></script>


<script>
    const fetchApi = import(
        'https://unpkg.com/@microsoft/fetch-event-source@2.0.1/lib/esm/index.js'
        ).then((module) => module.fetchEventSource);

    // This example stores the OpenAI API key in the client side integration. This is not recommended for any purpose.
    // Instead, an alternate method for retrieving the API key should be used.
    const openai_api_key = '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';
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    tinymce
        .init({
            selector: 'textarea#full-featured',
            plugins: 'importword exportword exportpdf preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link math media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker editimage help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable footnotes mergetags autocorrect typography advtemplate markdown',
            images_upload_url: '{{ route('author.articles.upload') }}',

            images_upload_handler: (blobInfo, progress) =>
                new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', "{{ route('author.articles.upload') }}");

                    xhr.onload = () => {
                        if (xhr.status === 200) {
                            try {
                                const json = JSON.parse(xhr.responseText);
                                if (json.location) {
                                    resolve(json.location);
                                } else {
                                    reject('Invalid response format');
                                }
                            } catch (e) {
                                reject('Invalid JSON response');
                            }
                        } else {
                            reject(`HTTP Error: ${xhr.status}`);
                        }
                    };

                    xhr.onerror = () => reject('Connection error');

                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('_token', "{{ csrf_token() }}");
                    xhr.send(formData);
                }),

            automatic_uploads: true,
            images_upload_credentials: false,
            // tinydrive_token_provider: 'ae65bcdf52b2b51143d84279e4393ca0129cad1971389dce9efe133d92adeb88',

            mobile: {
                plugins: ' preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link math media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable footnotes mergetags autocorrect typography advtemplate',
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
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },

            importcss_append: true,
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            spellchecker_ignore_list: ['Ephox', 'Moxiecode', 'tinymce', 'TinyMCE'],
            tinycomments_mode: 'embedded',
            content_style: '.mymention{ color: gray; }',
            contextmenu: 'link image editimage table configurepermanentpen',
            a11y_advanced_options: true,
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            autocorrect_capitalize: true,
            mergetags_list: [
                {
                    title: 'Client',
                    menu: [
                        {
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
                    menu: [
                        {
                            value: 'Proposal.SubmissionDate',
                            title: 'Submission date',
                        },
                    ],
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
    setTimeout(function () {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => alert.style.display = 'none');
    }, 3000);
</script>
