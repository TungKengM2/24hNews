<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '24h News')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .login-container {
            width: 100%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            margin: 50px auto;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .row {
            width: 100%;
            padding: 15px;

        }
        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        /* .form-section {
            width: 50%;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
        } */
        .profile-img {
            text-align: center;
        }

        .profile-img img {
        border-radius: 50%;
         }
        input[type="email"], input[type="password"], input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-icon input {
            padding-left: 30px;
        }
        #togglePassword {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .eye {
            position: absolute;
            top: 50%;
            right: 45px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 7px 10px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            opacity: 0.8;
        }
        .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin: 10px;
        border: none;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        width: 250px;
    }
    .btn img {
        margin-right: 10px;
        height: 24px;
        width: 24px;
    }
    .btn-google {
        background-color: #db4437;
        margin: 10px;
        width: 320px;
    }
    .btn-facebook {
        background-color: royalblue;
        width: 320px;
        margin: 10px;
    }
    .login-container {
        display: flex;
        justify-content: space-between;
    }
    .ads {
        width: 50%;
        background-color: #A569BD;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        color: #fff;
        padding: 15px;
        text-align: center;
    }
    .ads .img img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        object-fit: cover;
    }
    .form-section {
        width: 50%;
        padding: 15px;
    }
    .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin: 10px;
        border: none;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        width: 250px;
    }
    .btn img {
        margin-right: 10px;
        height: 24px;
        width: 24px;
    }
    .btn-google {
        background-color: #db4437;
        margin: 10px;
        width: 320px;
    }
    .btn-facebook {
        background-color: royalblue;
        width: 320px;
        margin: 10px;
    }

    </style>
</head>
<body>

    <div class="container">
        <div>
            @yield('content')
        </div>
    </div>

</body>
</html>
