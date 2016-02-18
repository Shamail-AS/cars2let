@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="container">
        <div class="add-btn">
            <a href="{{url('admin/driver/create')}}" class="nostyle">
                <i class="fa fa-plus fa-2x"></i>
            </a>
        </div>

        <h1>Manage Drivers</h1>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>License No.</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                    @foreach($driverList as $driver)
                        <tr>
                            <th>{{$driver->id}}</th>
                            <th>{{$driver->email}}</th>
                            <th>{{$driver->name}}</th>
                            <th>{{$driver->license_no}}</th>
                            <th>{{$driver->dob->toFormattedDateString()}}</th>
                            <th>{{$driver->phone}}</th>
                            <th>{{$driver->created_at->toFormattedDateString()}}</th>
                            <th>
                                <button class="btn btn-xs btn-primary">Some action</button>
                            </th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection