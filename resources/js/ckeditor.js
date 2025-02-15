import { ClassicEditor } from 'ckeditor5';
import {
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
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

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
                    'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent',
                ],
                shouldNotGroupWhenFull: false,
            },
            menuBar: {
                isVisible: true,
            },
            heading: {
                options: [
                    { modelElement: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { modelElement: 'heading1', viewElement: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { modelElement: 'heading2', viewElement: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { modelElement: 'heading', viewElement: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                ],
            },
        })
        .then(editor => {
            console.log('CKEditor initialized:', editor);
            const form = document.querySelector('form');
            form.addEventListener('submit', () => {
                const contentTextarea = document.querySelector('#content');
                if (contentTextarea) {
                    contentTextarea.value = editor.getData();
                }
            });
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });
});
