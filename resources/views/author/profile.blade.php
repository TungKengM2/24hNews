@extends('author.layouts.master')

@section('title')
    Author Profile
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="nav-tabs-custom">
                <div class="content">
                    <div class="pane" id="settings">

                        <div class="box no-shadow">
                            <form class="form-horizontal form-element col-12">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 form-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 form-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-2 form-label">Phone</label>

                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" id="inputPhone" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 form-label">Experience</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 form-label">Skills</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="ms-auto col-sm-10">
                                        <div class="checkbox">
                                            <input type="checkbox" id="basic_checkbox_1" checked="">
                                            <label for="basic_checkbox_1"> I agree to the</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="extra_profile.html#">Terms
                                                and Conditions</a>
                                        </div>
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
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
@endsection
