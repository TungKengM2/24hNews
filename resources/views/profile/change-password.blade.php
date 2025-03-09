@extends('profile.layouts.master')

@section('title')
    Đổi mật khẩu
@endsection

@section('content')
<div class="card p-4">
    <h4>Đổi mật khẩu</h4>
    <form action="{{ route('profile.update-password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
            @error('current_password') 
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
            @error('new_password') 
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
            @error('new_password_confirmation') 
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
    </form>
    
    <!-- Hiển thị thông báo nếu có -->
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
