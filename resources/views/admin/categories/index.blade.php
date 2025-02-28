@extends('admin.layouts.master')

@section('title')
    Danh Sách Danh Mục
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Danh Mục</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Danh Mục</li>
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
                            <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                    href="{{ route('categories.create') }}">
                                    <i class="si-plus si"></i>
                                </a></button>

                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="complex_header" class="table table-striped table-bordered display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">NAME</th>
                                            <th scope="col">SLUG</th>
                                            <th scope="col">IS ACTIVE</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td scope="row">{{ $category->category_id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->slug }}</td>
                                                <td>{{ $category->is_active ? 'Có' : 'Không' }}</td>
                                                <td class="d-flex">
                                                    <a class="btn btn-warning me-2"
                                                        href="{{ route('categories.edit', $category) }}">
                                                        <i class="si-pencil si"></i>
                                                    </a>
                                                    <form action="{{ route('categories.destroy', $category) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xoá không?')"
                                                            type="submit">
                                                            <i class="si-trash si"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('admin.layouts.partials.footer')

        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
@endsection
