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
       .select2-container--default .select2-selection--multiple .select2-selection__choice {
           background-color: #5A8DEE;
           color: white;
           border: 1px solid #5A8DEE;
           padding: 5px 10px;
           border-radius: 5px;
           font-size: 14px;
       }

       #image-preview-container {
           margin-top: 10px;
           text-align: center;
           max-width: 300px;
       }

       #image-preview {
           max-height: 150px;
           width: auto;
           border: 1px solid #ddd;
           border-radius: 4px;
           padding: 5px;
       }

       #moderation-result {
           margin-top: 10px;
       }

       .moderation-loading {
           text-align: center;
           padding: 10px;
       }

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

       .form-section {
           margin-bottom: 30px;
           padding: 20px;
           border-radius: 8px;
           background-color: #f9f9f9;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
       }

       .form-section-title {
           margin-bottom: 15px;
           padding-bottom: 10px;
           border-bottom: 1px solid #eee;
           font-weight: 600;
       }

       .action-buttons {
           margin-top: 30px;
           display: flex;
           gap: 10px;
       }

       /* Verification Criteria Styles */
       .verification-criteria {
           padding: 20px;
           border-radius: 8px;
           background-color: #f9f9f9;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
           margin-left: -10px;
           display: flex;
           flex-direction: column;
           margin-top: 0;
       }

       .verification-criteria-title {
           margin-bottom: 15px;
           padding-bottom: 10px;
           border-bottom: 1px solid #eee;
           font-weight: 600;
           color: #333;
       }

       .criteria-content {
           display: flex;
           flex-direction: column;
           min-height: 400px;
       }

       .criteria-list {
           list-style: none;
           padding: 0;
           margin: 0;
           margin-bottom: 0;
       }

       .criteria-item {
           display: flex;
           align-items: center;
           padding: 10px 0;
           border-bottom: 1px solid #eee;
           cursor: pointer;
           transition: all 0.3s ease;
       }

       .criteria-item:last-child {
           border-bottom: none;
       }

       .criteria-icon {
           width: 24px;
           height: 24px;
           display: flex;
           align-items: center;
           justify-content: center;
           border-radius: 50%;
           margin-right: 10px;
           font-weight: bold;
           transition: all 0.3s ease;
       }

       .criteria-icon.failed {
           background-color: #f1f1f1;
           color: #999;
       }

       .criteria-icon.passed {
           background-color: #28a745;
           color: white;
       }

       .criteria-text {
           flex: 1;
           transition: color 0.3s ease;
       }

       .criteria-item.failed .criteria-text {
           color: #777;
       }

       .criteria-item.passed .criteria-text {
           color: #28a745;
           font-weight: 500;
       }

       .criteria-tooltip {
           position: relative;
       }

       .criteria-tooltip .tooltip-text {
           visibility: hidden;
           width: 200px;
           background-color: #333;
           color: #fff;
           text-align: center;
           border-radius: 6px;
           padding: 5px;
           position: absolute;
           z-index: 1;
           bottom: 125%;
           left: 50%;
           margin-left: -100px;
           opacity: 0;
           transition: opacity 0.3s;
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

       /* Vertical progress bar */
       .criteria-progress {
           position: relative;
           width: 8px;
           height: 120px;
           background-color: #e9ecef;
           border-radius: 4px;
           overflow: hidden;
           margin: 0 auto;
       }

       .criteria-progress-bar {
           position: absolute;
           bottom: 0;
           width: 100%;
           background-color: #28a745;
           border-radius: 4px;
           transition: height 0.5s ease;
       }

       .progress-container {
           display: flex;
           flex-direction: column;
           align-items: center;
           margin-top: 20px;
           margin-bottom: 10px;
       }

       @keyframes pulse {
           0% {
               transform: scale(1);
           }
           50% {
               transform: scale(1.05);
           }
           100% {
               transform: scale(1);
           }
       }

       .criteria-item.just-passed {
           animation: pulse 0.5s ease;
       }
       .widget-user .widget-user-image>img {
            width: 100%;
            height: 100%;

        }

        .widget-user-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .widget-user-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-profile img {
            width: 90px;
            height: 90px;
            margin: 0 auto;
            border-radius: 100px !important;
            /* border: 5px solid rgba(255, 255, 255, 0.3); */
        }

        .widget-user-image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            /* background: linear-gradient(135deg, #ff7e5f, #feb47b); */
            padding: 0px;
        }

        .box-footer {
            background-color: #00000080;
        }

        .widget-user .widget-user-image {
            position: absolute;
            top: 90px;
            left: 45%;

        }

        .widget-user-image {
            position: relative;
            width: 128px;
            height: 128px;
            margin: 1px !important;
            border: 3px solid #fff;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
   </style>
