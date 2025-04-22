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
