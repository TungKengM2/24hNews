   <!-- Vendors Style-->
   <link rel="stylesheet" href="/admin/main/css/vendors_css.css">

   <!-- Style-->
   <link rel="stylesheet" href="/admin/main/css/style.css">
   <link rel="stylesheet" href="/admin/main/css/skin_color.css">

   <style>
       .widget-user-image {
           display: flex;
           align-items: center;
           justify-content: center;
           width: 120px;
           /* Kích thước tổng thể */
           height: 120px;
           border-radius: 50%;
           overflow: hidden;
           /* background: linear-gradient(135deg, #ff7e5f, #feb47b); */
           /* Viền gradient đẹp hơn */
           padding: 3px;
           /* Tạo khoảng cách giữa ảnh và viền */
       }

       .widget-user-image img {
           width: 100%;
           height: 100%;
           object-fit: cover;
           border-radius: 50%;
       }

       .widget-user-image:hover {
           box-shadow: 0px 0px 10px rgba(250, 51, 1, 0.8);
       }
   </style>

   <style>
       /* Tags styling */
       .select2-container--default .select2-selection--multiple .select2-selection__choice {
           background-color: #c3bebe;
           color: white;
           border: 1px solid #c2c2c2;
           padding: 5px 20px;
           border-radius: 5px;
           font-size: 14px;
       }

       /* Image preview styling */
       #image-preview-container {
           margin-top: 10px;
           text-align: center;
           max-width: 300px;
       }

       #image-preview {
           max-height: 150px;
           max-width: 100%;
           width: auto;
           border: 1px solid #ddd;
           border-radius: 4px;
           padding: 5px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
       }

       /* Moderation result styling */
       #moderation-result {
           margin-top: 10px;
       }

       .moderation-loading {
           text-align: center;
           padding: 10px;
       }

       /* Violation levels */
       .violation-high {
           color: #dc3545;
           font-weight: bold;
       }

       .violation-medium {
           color: #fd7e14;
           font-weight: bold;
       }

       .violation-low {
           color: #ffc107;
       }

       .violation-none {
           color: #28a745;
       }

       /* Form section styling */
       .form-section {
           background-color: #f8f9fa;
           border-radius: 8px;
           padding: 20px;
           margin-bottom: 20px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
       }

       .form-section-title {
           border-bottom: 1px solid #dee2e6;
           padding-bottom: 10px;
           margin-bottom: 20px;
           font-weight: 600;
       }

       /* Button styling */
       .action-buttons {
           margin-top: 30px;
       }

       .action-buttons .btn {
           padding: 8px 20px;
           margin-right: 10px;
       }

       /* Tiêu chí xuất bản styling */
       .verification-criteria {
           background-color: #f8f9fa;
           border-radius: 8px;
           padding: 20px;
           margin-bottom: 20px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
           max-height: calc(100vh - 40px);
           /* Chiều cao tối đa là chiều cao của viewport trừ đi khoảng cách từ top */
           overflow-y: auto;
           /* Cho phép cuộn nếu nội dung quá dài */
       }

       /* Class được thêm bằng JavaScript khi cuộn trang */
       .verification-criteria.fixed {
           position: fixed;
           top: 20px;
           z-index: 100;
           width: 23%;
           /* Tương ứng với col-md-3 */
       }

       .verification-criteria-title {
           border-bottom: 1px solid #dee2e6;
           padding-bottom: 10px;
           margin-bottom: 20px;
           font-weight: 600;
       }

       .criteria-list {
           list-style: none;
           padding: 0;
           margin-bottom: 20px;
       }

       .criteria-item {
           display: flex;
           align-items: flex-start;
           margin-bottom: 10px;
           padding: 8px;
           border-radius: 4px;
           transition: background-color 0.3s;
       }

       .criteria-item:hover {
           background-color: #f0f0f0;
       }

       .criteria-icon {
           margin-right: 10px;
           font-weight: bold;
           font-size: 16px;
           min-width: 20px;
           text-align: center;
       }

       .criteria-icon.passed {
           color: #28a745;
       }

       .criteria-icon.failed {
           color: #dc3545;
       }

       .criteria-text {
           flex: 1;
           position: relative;
       }

       .criteria-tooltip {
           cursor: help;
       }

       .criteria-tooltip .tooltip-text {
           visibility: hidden;
           width: 250px;
           background-color: #333;
           color: #fff;
           text-align: center;
           border-radius: 6px;
           padding: 8px;
           position: absolute;
           z-index: 1;
           bottom: 125%;
           left: 50%;
           margin-left: -125px;
           opacity: 0;
           transition: opacity 0.3s;
           font-size: 12px;
       }

       .criteria-tooltip .tooltip-text::after {
           content: "";
           position: absolute;
           top: 100%;
           left: 50%;
           margin-left: -5px;
           border-width: 5px;
           border-style: solid;
           border-color: #333 transparent transparent transparent;
       }

       .criteria-tooltip:hover .tooltip-text {
           visibility: visible;
           opacity: 1;
       }

       .criteria-progress {
           width: 8px;
           height: 100%;
           background-color: #e9ecef;
           border-radius: 4px;
           overflow: hidden;
           margin-right: 10px;
       }

       .criteria-progress-bar {
           width: 100%;
           background-color: #28a745;
           border-radius: 4px;
           height: 0%;
           transition: height 0.3s ease;
           position: absolute;
           bottom: 0;
       }

       .criteria-item.passed #current-title-length,
       .criteria-item.passed #current-tag-count,
       .criteria-item.passed #current-word-count {
           color: #28a745 !important;
       }

       .criteria-item.failed #current-title-length,
       .criteria-item.failed #current-tag-count,
       .criteria-item.failed #current-word-count {
           color: #dc3545 !important;
       }

       .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
           /* background-color:;
           border: none; */
           /* border-right: 1px solid #aaa; */
           /* border-top-left-radius: 4px;
           border-bottom-left-radius: 4px;
           color: black;
           cursor: pointer;
           font-size: 1em;
           font-weight: bold;
           padding: 0 4px;
           position: absolute;
           left: 2px;
           top: 5px; */
       }

       .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
           background-color: #5A8DEE;
           color: #c3bebe;
       }

       .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {

           color: white;
           border: none;

           padding: 5px 10px;
           border-radius: 5px;
           font-size: 14px;
       }

       .table-bordered> :not(caption)>* {
           border-width: none !important;
       }

       .thead,
       tbody,
       tfoot,
       tr,
       td,
       th {
           border-color: none !important;
           border-style: none !important;
           border: none !important;

       }

       .table-bordered>tbody>tr>td,
       .table-bordered>tbody>tr>th {
           /* border-width: 1px !important; */
           /* border-style: solid !important;
           /* border-color: rgb(209, 211, 224) !important; */
           /* border-image: initial !important; */
       }

       .main-header .logo .logo-mini .light-logo {
           display: flex;
           align-items: center;
           justify-content: center;
       }

       .image {
           max-width: 100%;
           margin-top: 15px !important;
       }
   </style>
