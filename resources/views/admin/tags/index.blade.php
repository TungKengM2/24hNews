@extends('admin.layouts.master')

@section('title')
    Danh Sách Thẻ
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Thẻ</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Thẻ</li>
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
                            <button type="button" class="waves-effect waves-light btn btn-default mb-5">
                                <a href="{{ route('admin.dashboard') }}">Quay lại</a>
                            </button>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="complex_header" class="table table-striped table-bordered display"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Thẻ</th>
                                            <th>Số Lượng Bài Viết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $tag)
                                            <tr>
                                                <td>{{ $tag->tag_id }}</td>
                                                <td>{{ $tag->name }}</td> <!-- Tên thẻ -->
                                                <td>{{ $tag->published_articles_count }}</td>
                                                <!-- Số bài viết đã xuất bản -->
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            {{-- Nếu có phân trang --}}
                            {{ $tags->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.partials.footer')
        <div class="control-sidebar-bg"></div>
    </div>
@endsection
