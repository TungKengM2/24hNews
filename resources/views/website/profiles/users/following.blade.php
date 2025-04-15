@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($user->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($user->role->name) }}</p>
                        @endif
                        <h2> {{ $user->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->
        


        <!-- ====== start author-details ====== -->
        <section class="tc-author-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="">
                        <div class="content">
                            <div class="author-img img-cover">
                                <div class="widget-user-image">
                                    <img class="rounded-circle"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                                        alt="Avatar">
                                    <label for="avatarUpload" class="avatar-edit">
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                    </label>
                                    <input type="file" id="avatarUpload" name="image" accept="image/*"
                                        style="display: none;">
                                </div>
                            </div>
                            
                            <div class="info mt-20">
                                <div class="description mt-20">
                                   
                                    </p>
                                    {{-- dat them hiển thị bài viết đã xem --}}
                                    <h4 class="page-title">Danh sách những người bạn đang theo dõi</h4>
                                        <div class="">
                                            <div class="table-responsive">
                                                @if ($followingUsers->isEmpty())
                                                    <p>Bạn chưa theo dõi ai.</p>
                                                @else
                                                    <table class="table table-bordered text-dark bg-white mb-0" style="border: 2px solid black;">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Ảnh đại diện</th>
                                                                <th>Tên người dùng</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($followingUsers as $index => $user)
                                                                <tr>
                                                                    <td>{{ $loop->iteration + ($followingUsers->currentPage() - 1) * $followingUsers->perPage() }}
                                                                    </td>
                                                                    <td>
                                                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-avatar.png') }}"
                                                                            alt="{{ $user->username }}" width="50" height="50">
                                                                    </td>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('website.profileAuth', ['id' => $user->user_id]) }}">{{ $user->username }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <form action="{{ route('user.unfollow', $user->user_id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm">Hủy Follow</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                
                                            <!-- Phân trang -->
                                            <div class="d-flex justify-content-end mt-3">
                                                {{ $followingUsers->links('pagination::bootstrap-5') }}
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
