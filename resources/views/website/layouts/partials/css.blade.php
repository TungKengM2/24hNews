    <link rel="shortcut icon" href="/images/logo1.png" title="Favicon" sizes="16x16" />
    <link rel="stylesheet" href="/client/assets/css/lib/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/client/assets/css/lib/ionicons.css">
    <link rel="stylesheet" href="/client/assets/css/lib/line-awesome.css">
    <link rel="stylesheet" href="/client/assets/css/lib/animate.css" />
    <link rel="stylesheet" href="/client/assets/css/lib/jquery.fancybox.css" />
    <link rel="stylesheet" href="/client/assets/css/lib/lity.css" />
    <link rel="stylesheet" href="/client/assets/css/lib/swiper.min.css" />
    <link rel="stylesheet" href="/client/assets/css/style.css" />

    <!-- search dat them -->
    <style>
        .suggestions-list {
            position: absolute;
            width: 100%;
            max-height: 250px; /* Giảm chiều cao tối đa vì chỉ có 5 gợi ý */
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            z-index: 1000;
            margin-top: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .suggestion-item {
            padding: 12px 15px; /* Tăng padding để mỗi mục cao hơn */
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5; /* Tăng line-height để dễ đọc hơn */
            font-size: 15px; /* Tăng kích thước chữ */
        }
        .suggestion-item:hover {
            background-color: #f0f8ff;
        }
        .suggestion-item:last-child {
            border-bottom: none;
        }
        .suggestion-item strong {
            font-weight: bold;
            color: #0056b3;
            background-color: rgba(0, 123, 255, 0.1);
            padding: 0 2px;
            border-radius: 2px;
        }

        .suggestions-list {
                    position: absolute;
                    width: 100%;
                    max-height: 300px;
                    overflow-y: auto;
                    background: white;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    z-index: 1000;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                .suggestion-item {
                    padding: 8px 12px;
                    cursor: pointer;
                    border-bottom: 1px solid #f0f0f0;
                    display: flex;
                    align-items: center;
                }
                .suggestion-item:hover {
                    background-color: #f5f5f5;
                }
                .suggestion-section-header {
                    display: block;
                    padding: 8px 12px;
                    background-color: #f9f9f9;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold;
                    color: #555;
                    text-align: center;
                }
                .suggestion-item.title {
                    background-color: #fff;
                }
                .suggestion-item.category {
                    background-color: #f0f8ff;
                    display: flex;
                    align-items: center;
                }
                .suggestion-item.category:before {
                    content: "Danh mục:";
                    font-size: 0.8em;
                    color: #666;
                    margin-right: 8px;
                    background: #e0e0ff;
                    padding: 2px 5px;
                    border-radius: 3px;
                }
                .suggestion-item.tag {
                    background-color: #f8fff0;
                    display: flex;
                    align-items: center;
                }
                .suggestion-item.tag:before {
                    content: "Thẻ:";
                    font-size: 0.8em;
                    color: #666;
                    margin-right: 8px;
                    background: #e0ffd0;
                    padding: 2px 5px;
                    border-radius: 3px;
                }
    </style>