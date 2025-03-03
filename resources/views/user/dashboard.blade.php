@extends('user.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper container">
        <div class="container-full">
            <section class="content">

                <div class="row">
                    <div class="user-profile">
                        <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-img bbsr-0 bber-0"
                                style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
                                <h3 class="widget-user-username text-white">Tên User</h3>
                                <h6 class="widget-user-desc text-white">User</h6>
                            </div>
                            <div class="widget-user-image">
                                <img class="rounded-circle" src="/admin/main/../images/user3-128x128.jpg" alt="User Avatar">
                            </div>
                            <div class="box-footer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-body box-profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <p>Email :<span class="text-gray ps-10">David@yahoo.com</span> </p>
                                            <p>Phone :<span class="text-gray ps-10">+11 123 456 7890</span></p>
                                            <p>Address :<span class="text-gray ps-10">123, Lorem Ipsum, Florida,
                                                    USA</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                </div>
                <!-- /.row -->

            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
