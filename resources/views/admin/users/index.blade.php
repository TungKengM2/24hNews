@extends('admin.layouts.master')

@section('title')
    Danh Sách Tài Khoản
@endsection

@section('content')

    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Duyệt Tác Giả</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Nâng Cấp Tài Khoản</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <div class="container-full">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">

                            <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                    href="{{ route('admin.dashboard') }}">
                                    Back to Dashboard
                                </a></button>
                            <button type="button" class="waves-effect waves-light btn btn-primary mb-5"><a
                                    href="{{ route('articles.create') }}">
                                    <i class="si-plus si"></i>
                                </a></button>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                    <i class="fa-solid fa-circle-check me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    {{ session('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark mb-0"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Current Role</th>
                                        <th>Application Reason</th>
                                        <th>Registration Date</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($requests as $req)
                                        <tr>

                                            <td>{{ $req->user->username }}</td>
                                            <td>{{ $req->user->email }}</td>
                                            <td>{{ $req->user->phone }}</td>
                                            <td>{{ $req->user->role->name }}</td>
                                            <td> {{ $req->remarks }}</td>
                                            <td>{{ $req->user->created_at }}</td>
                                            <td> {{ $req->created_at }}</td>
                                            <td>
                                                @if ($req->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($req->status === 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif ($req->status === 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($req->status === 'pending')
                                                    <form
                                                        action="{{ route('admin.approve-role-upgrade', $req->approval_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Xác nhận duyệt yêu cầu này?')">
                                                            Duyệt
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route('admin.reject-role-upgrade', $req->approval_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Xác nhận từ chối yêu cầu này?')">
                                                            Từ chối
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            {{--                                            {{ $articles->links('pagination::bootstrap-5') }}--}}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
        </div>
    </div>
    <script>
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const alertInstance = bootstrap.Alert.getInstance(alert);
                if (alertInstance) {
                    alertInstance.close();
                } else {
                    alert.style.display = 'none';
                }
            });
        }, 3000);
    </script>
@endsection
