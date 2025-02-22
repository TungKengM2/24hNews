<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .admin-container {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            background: #23282d;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            background: #32373c;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background: #3c434a;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: #f1f1f1;
        }
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .filter-bar .filters a {
            margin-right: 15px;
            text-decoration: none;
            color: #007cba;
            font-weight: bold;
        }
        .filter-bar .filters a:not(:last-child)::after {
            content: " | ";
            color: #000;
        }
        .filter-bar .filters a:hover {
            text-decoration: underline;
        }
        .search-box {
            display: flex;
            align-items: center;
        }
        .search-box input {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 5px;
        }
        .search-box button {
            padding: 8px 12px;
            background: #007cba;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .search-box button:hover {
            background: #005a8e;
        }
        .bulk-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .bulk-actions select, .bulk-actions button {
            padding: 8px;
        }
        .bulk-actions button:nth-of-type(1) {
            margin-right: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background: #f9f9f9;
            font-weight: bold;
        }
        tbody tr:hover {
            background: #f3f3f3;
        }
        .post-title {
            display: flex;
            align-items: center;
        }
        .post-title img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .post-actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007cba;
        }
        .post-actions a:hover {
            text-decoration: underline;
        }
        .charts-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .chart-container {
            width: 45%;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chart-container canvas {
            width: 100% !important;
            height: auto !important;
            max-height: 400px;
        }
    </style>
</head>
<body>
<div class="admin-container">
    @include('author.layouts.sidebar')
    <main class="content">
        @yield('content')
    </main>
</div>
</body>
</html>
