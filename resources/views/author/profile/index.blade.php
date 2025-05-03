@extends('author.layouts.master')

@section('title')
    Author Profile
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="nav-tabs-custom">
                <div class="content">
                    <div class="pane" id="settings">
                        <div class="box no-shadow">
                            <form class="form-horizontal form-element col-12"
                                  action="{{ route('author.profile.update') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="username"
                                               value="{{ $user->username }}" placeholder="Enter your name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" name="email"
                                               value="{{ $user->email }}" placeholder="Enter your email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-2 form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" id="inputPhone" name="phone"
                                               value="{{ $user->phone }}" placeholder="Enter your phone number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputImage" class="col-sm-2 form-label">Profile Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputImage" name="image">
                                        @if($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                                 style="max-width: 100px; margin-top: 10px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="ms-auto col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
