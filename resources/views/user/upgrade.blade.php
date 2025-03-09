@extends('user.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Nâng cấp tài khoản thành Tác giả</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.upgrade.author') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="reason">Lý do yêu cầu nâng cấp <span class="text-danger">*</span></label>
                                <textarea id="reason" name="reason" class="form-control" rows="4"
                                          placeholder="Nhập lý do bạn muốn trở thành tác giả" required></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Gửi yêu cầu nâng cấp</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
