<div class="col-md-9">
    <div class="profile-content">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h2>Thông Tin Người Dùng</h2>
        <div class="user-info">
            <ul class="list-group">
                <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $user->phone }}</li>
                {{--                <li class="list-group-item"><strong>Địa chỉ:</strong> Cao Đẳng FPT , Trịnh Văn Bô , Nam Từ Liêm , Hà Nội--}}
                </li>
            </ul>
        </div>
        <div class="user-settings mt-4">
            <h3>Cài đặt tài khoản</h3>
            <button class="btn btn-primary">Chỉnh sửa thông tin</button>
            <button class="btn btn-danger">Đổi mật khẩu</button>
        </div>
    </div>
</div>
