<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả kiểm duyệt</title>
</head>
<body>
<h1>Kết quả kiểm duyệt</h1>
@if($result['status'] === 'success')
    @if($result['violation_level'] === 'none')
        <p>Không vi phạm.</p>
    @else
        <p>Mức độ vi phạm: {{ ucfirst($result['violation_level']) }}</p>
        <p>Các từ vi phạm: {{ implode(', ', $result['violations']) }}</p>
        <p><strong>Lý do vi phạm:</strong></p>
        <ul>
            @foreach($result['reason'] as $word => $reason)
                <li><strong>{{ $word }}:</strong> {{ $reason }}</li>
            @endforeach
        </ul>
    @endif
@else
    <p>Lỗi: {{ $result['message'] }}</p>
@endif
<a href="{{ route('moderate.form') }}">Quay lại</a>
</body>
</html>
