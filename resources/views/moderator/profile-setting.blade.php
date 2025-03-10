@extends('moderator.layouts.master')

@section('title')
    Moderator Setting
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="nav-tabs-custom">
                <div class="content">
                    <h4>Đổi mật khẩu</h4>

                    <div class="pane" id="settings">

                        <div class="box no-shadow">
                            <form action="{{ route('profile.update-password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="current_password">Mật khẩu hiện tại</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-control" required>
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="new_password">Mật khẩu mới</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control"
                                        required>
                                    @error('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                        class="form-control" required>
                                    @error('new_password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                            </form>

                            @if (session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
