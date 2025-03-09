<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm duyệt nội dung</title>
</head>
<body>
<h1>Kiểm duyệt nội dung</h1>
<form action="{{ route('moderate.submit') }}" method="POST">
    @csrf
    <textarea name="text" rows="5" cols="50" placeholder="Nhập nội dung cần kiểm duyệt"></textarea><br><br>
    <button type="submit">Kiểm duyệt</button>
</form>
</body>
</html>
