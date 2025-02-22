import {
    ClassicEditor,
    CloudServices,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Font,
    Indent,
    BlockQuote,
    Emoji,
    Mention,
    TextTransformation,
    Code,
    Strikethrough,
    Subscript,
    Superscript,
    Underline,
    CodeBlock,
    Image,
    ImageUpload,
    PictureEditing,
    CKBox,
    CKBoxImageEdit,
    LinkEditing,
    ImageInsert,
    CKFinder,
    CKFinderUploadAdapter,
    Link,
    FindAndReplace,
    Highlight,
    HorizontalLine,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    LinkImage,
    ImageResizeEditing, ImageResizeHandles,
} from 'ckeditor5';
import {
    ExportPdf,
    ExportWord,
    ImportWord,
    Uploadcare,
    FormatPainter,
} from 'ckeditor5-premium-features';

import 'ckeditor5/ckeditor5.css';

// form.addEventListener('submit', () => {
//     const contentTextarea = document.querySelector('#content');
//     if (contentTextarea) {
//         contentTextarea.value = editor.getData();
//         console.log('Content to be submitted:', contentTextarea.value); // Debugging
//     }
// });

document.addEventListener('DOMContentLoaded', () => {
    ClassicEditor
        .create(document.querySelector('#content'), {
            licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDA4NzM1OTksImp0aSI6IjU3NjMyMzYyLThjYzktNGI5OS04YTk4LTA3YTQ0NTRhOTk2OSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImY3ODMxZjUwIn0.8zMtmfSOdINS8gAXMt-u-ORW6jDDZLl5fJejawSrIC7aeWgLGNiBwgApykggy8_Z789xYoaJ4aygTNI0YniwRA',
            plugins: [
                Essentials,
                Paragraph,
                Bold,
                Italic,
                Font,
                Indent,
                BlockQuote,
                Emoji,
                Mention,
                TextTransformation,
                Code,
                Strikethrough,
                Subscript,
                Superscript,
                Underline,
                // Title,
                CodeBlock,
                ExportPdf,
                CloudServices,
                ExportWord,
                ImportWord,
                Image, PictureEditing, ImageUpload, CKBox, CKBoxImageEdit, LinkEditing, Uploadcare, ImageInsert, CKFinder, CKFinderUploadAdapter,
                Link, FindAndReplace, FormatPainter, Highlight, HorizontalLine, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage,
                ImageResizeEditing, ImageResizeHandles,

            ],
            toolbar: {
                items: [
                    'undo', 'redo', 'emoji',
                    '|',
                    'heading',
                    '|',
                    'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                    '|',
                    'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                    '|',
                    'link', 'uploadImage', 'blockQuote', 'codeBlock',
                    '|',
                    'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent', 'caseChange',
                    'codeBlock', 'exportPdf', 'exportWord', 'importWord', 'ckbox', 'ckboxImageEdit', 'ImageInsert', 'ckfinder', 'findAndReplace', 'highlight',
                    'formatPainter', 'horizontalLine', 'insertImage',

                ],

                shouldNotGroupWhenFull: false,
            },
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    value: null,
                    label: 'Original',
                },
                {
                    name: 'resizeImage:custom',
                    label: 'Custom',
                    value: 'custom',
                },
                {
                    name: 'resizeImage:40',
                    value: '40',
                    label: '40%',
                },
                {
                    name: 'resizeImage:60',
                    value: '60',
                    label: '60%',
                },
            ],
            ckbox: {
                // Configuration.
            },
            importWord: {
                // Configuration.
                tokenUrl: 'https://apyf7qowpi43.cke-cs.com/token/dev/27d01afbe09470427d714aac32cf5ec89984c6226ad91e72347db760582b?limit=10',
                formatting: {
                    resets: 'none',
                    defaults: 'none',
                    styles: 'inline',
                    comments: 'full',
                },
            },
            exportPdf: {
                stylesheets: [
                    /* This path should point to application stylesheets. */
                    /* See: https://ckeditor.com/docs/ckeditor5/latest/features/converters/export-pdf.html */
                    './app.component.css',
                    /* Export PDF needs access to stylesheets that style the content. */
                    'https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css',
                    'https://cdn.ckeditor.com/ckeditor5-premium-features/44.2.0/ckeditor5-premium-features.css',
                ],
                fileName: 'export-pdf-demo.pdf',
                converterOptions: {
                    format: 'Tabloid',
                    margin_top: '20mm',
                    margin_bottom: '20mm',
                    margin_right: '24mm',
                    margin_left: '24mm',
                    page_orientation: 'portrait',
                },
            },
            exportWord: {
                stylesheets: [
                    /* This path should point to application stylesheets. */
                    /* See: https://ckeditor.com/docs/ckeditor5/latest/features/converters/export-word.html */
                    './app.component.css',
                    /* Export Word needs access to stylesheets that style the content. */
                    'https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css',
                    'https://cdn.ckeditor.com/ckeditor5-premium-features/44.2.0/ckeditor5-premium-features.css',
                ],
                fileName: 'export-word-demo.docx',
                converterOptions: {
                    document: {
                        orientation: 'portrait',
                        size: 'Tabloid',
                        margins: {
                            top: '20mm',
                            bottom: '20mm',
                            right: '24mm',
                            left: '24mm',
                        },
                    },
                },
            },
            image: {
                toolbar: [
                    'toggleImageCaption',
                    'imageTextAlternative',
                    '|',
                    'imageStyle:block',
                    'imageStyle:inline',
                    'imageStyle:wrapText',
                    'imageStyle:breakText',
                    '|',
                    'resizeImage',
                    '|',
                    'ckboxImageEdit',
                    'uploadcareImageEdit',
                    '|',
                    'linkImage',
                ],
                insert: {
                    // This is the default configuration, you do not need to provide
                    // this configuration key if the list content and order reflects your needs.
                    integrations: ['upload', 'assetManager', 'url'],
                    type: 'auto',
                },
            },
            uploadcare: {
                pubkey: 'aaa0cd5e8c20e0a055d7',
                uploader: {
                    sourceList: [
                        'local',
                        'dropbox',
                        'onedrive',
                        'facebook',
                        'gdrive',
                        'gphotos',
                        'url',
                    ],
                },
                allowExternalImagesEditing: [/.*/],
            },
            cloudServices: {
                tokenUrl: 'https://apyf7qowpi43.cke-cs.com/token/dev/27d01afbe09470427d714aac32cf5ec89984c6226ad91e72347db760582b?limit=10',
            },
            menuBar: {
                isVisible: true,
            },

            fontFamily: {
                supportAllValues: true,
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true,
            },
            heading: {
                options: [
                    {
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph',
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1',
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2',
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3',
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4',
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5',
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6',
                    },
                ],
            }, fontColor: {
                colors: [
                    {
                        color: 'hsl(0, 0%, 0%)',
                        label: 'Black',
                    },
                    {
                        color: 'hsl(0, 0%, 30%)',
                        label: 'Dim grey',
                    },
                    {
                        color: 'hsl(0, 0%, 60%)',
                        label: 'Grey',
                    },
                    {
                        color: 'hsl(0, 0%, 90%)',
                        label: 'Light grey',
                    },
                    {
                        color: 'hsl(0, 0%, 100%)',
                        label: 'White',
                        hasBorder: true,
                    },
                    {
                        color: 'hsl(0, 75%, 60%)',
                        label: 'Red',
                    },
                    {
                        color: 'hsl(30, 75%, 60%)',
                        label: 'Orange',
                    },
                    {
                        color: 'hsl(60, 75%, 60%)',
                        label: 'Yellow',
                    },
                    {
                        color: 'hsl(90, 75%, 60%)',
                        label: 'Light green',
                    },
                    {
                        color: 'hsl(120, 75%, 60%)',
                        label: 'Green',
                    },
                    {
                        color: 'hsl(150, 75%, 60%)',
                        label: 'Aquamarine',
                    },
                    {
                        color: 'hsl(180, 75%, 60%)',
                        label: 'Turquoise',
                    },
                    {
                        color: 'hsl(210, 75%, 60%)',
                        label: 'Light blue',
                    },
                    {
                        color: 'hsl(240, 75%, 60%)',
                        label: 'Blue',
                    },
                    {
                        color: 'hsl(270, 75%, 60%)',
                        label: 'Purple',
                    },
                ],
                columns: 6,
                documentColors: 24,

            },
            fontBackgroundColor: {
                colors: [
                    {
                        color: 'hsl(0, 0%, 0%)',
                        label: 'Black',
                    },
                    {
                        color: 'hsl(0, 0%, 30%)',
                        label: 'Dim grey',
                    },
                    {
                        color: 'hsl(0, 0%, 60%)',
                        label: 'Grey',
                    },
                    {
                        color: 'hsl(0, 0%, 90%)',
                        label: 'Light grey',
                    },
                    {
                        color: 'hsl(0, 0%, 100%)',
                        label: 'White',
                        hasBorder: true,
                    },
                    {
                        color: 'hsl(0, 75%, 60%)',
                        label: 'Red',
                    },
                    {
                        color: 'hsl(30, 75%, 60%)',
                        label: 'Orange',
                    },
                    {
                        color: 'hsl(60, 75%, 60%)',
                        label: 'Yellow',
                    },
                    {
                        color: 'hsl(90, 75%, 60%)',
                        label: 'Light green',
                    },
                    {
                        color: 'hsl(120, 75%, 60%)',
                        label: 'Green',
                    },
                    {
                        color: 'hsl(150, 75%, 60%)',
                        label: 'Aquamarine',
                    },
                    {
                        color: 'hsl(180, 75%, 60%)',
                        label: 'Turquoise',
                    },
                    {
                        color: 'hsl(210, 75%, 60%)',
                        label: 'Light blue',
                    },
                    {
                        color: 'hsl(240, 75%, 60%)',
                        label: 'Blue',
                    },
                    {
                        color: 'hsl(270, 75%, 60%)',
                        label: 'Purple',
                    },
                ],
            },
            htmlSupport: {
                allow: [
                    {
                        name: /^.*$/,
                        styles: true,
                        attributes: true,
                        classes: true,
                    },
                ],
            },
            highlight: {
                options: [
                    {
                        model: 'greenMarker',
                        class: 'marker-green',
                        title: 'Green marker',
                        color: 'rgb(25, 156, 25)',
                        type: 'marker',
                    },
                    {
                        model: 'yellowMarker',
                        class: 'marker-yellow',
                        title: 'Yellow marker',
                        color: '#cac407',
                        type: 'marker',
                    },
                    {
                        model: 'redPen',
                        class: 'pen-red',
                        title: 'Red pen',
                        color: 'hsl(343, 82%, 58%)',
                        type: 'pen',
                    },
                ],
            },

        })
        .then(editor => {
            console.log('CKEditor initialized:', editor);
            const form = document.querySelector('form');
            form.addEventListener('submit', () => {
                const contentTextarea = document.querySelector('#content');
                if (contentTextarea) {
                    let htmlContent = editor.getData();
                    const plainTextWithFormatting = convertHtmlToPlainText(htmlContent);
                    contentTextarea.value = plainTextWithFormatting.trim();
                    console.log('Plain text with formatting to be submitted:', contentTextarea.value);
                }
            });
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });

    function convertHtmlToPlainText(html) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;

        const processNode = (node) => {
            if (node.nodeType === Node.TEXT_NODE) {
                return node.textContent;
            }

            if (node.nodeType === Node.ELEMENT_NODE) {
                let text = '';
                switch (node.tagName.toLowerCase()) {
                    case 'b':
                    case 'strong':
                        text = `**${processChildren(node)}**`; // In đậm
                        break;
                    case 'i':
                    case 'em':
                        text = `_${processChildren(node)}_`; // Nghiêng
                        break;
                    case 'span':
                        const color = node.style.color;
                        if (color) {
                            text = `[${color}]${processChildren(node)}[/${color}]`; // Màu sắc
                        } else {
                            text = processChildren(node);
                        }
                        break;
                    default:
                        text = processChildren(node);
                }
                return text;
            }
            return '';
        };

        const processChildren = (parent) => {
            let result = '';
            Array.from(parent.childNodes).forEach(child => {
                result += processNode(child);
            });
            return result;
        };

        return processChildren(tempDiv);
    }
});