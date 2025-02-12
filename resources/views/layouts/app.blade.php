<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '24h News')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px ;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
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
        <form>
            @yield('content')
        </form>
    </div>

</body>
</html>
