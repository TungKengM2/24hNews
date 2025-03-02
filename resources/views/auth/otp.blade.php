@extends('layouts.app')

@section('title', 'Xác nhận OTP')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Xác nhận OTP</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('otp.verify.process') }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label">Nhập mã OTP đã nhận qua email:</label>
                <input type="text" name="otp" id="otp" class="form-control"
                       inputmode="numeric" pattern="\d{6}" maxlength="6"
                       required placeholder="Nhập 6 chữ số OTP" autofocus>
            </div>

            <button type="submit" class="btn btn-primary">Xác nhận OTP</button>
        </form>
    </div>
@endsection
