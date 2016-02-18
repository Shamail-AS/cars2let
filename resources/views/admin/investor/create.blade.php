@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Register a new Investor
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" role="form" method="POST" action="{{url("/admin/investor/store")}}">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="name" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>Investor email</label>
                                        <input class="form-control" type="text" name="email" placeholder="someone@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label>Passport Number</label>
                                        <input class="form-control" type="text" name="passport_num" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of birth</label>
                                        <input class="form-control" type="date" name="dob" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input class="form-control" type="number" name="phone" placeholder="">
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-btn fa-user"></i>Register
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection