@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="container">
        <div class="add-btn">
            <a href="{{url('admin/investor/create')}}" class="nostyle">
                <i class="fa fa-plus fa-2x"></i>
            </a>
        </div>

        <h1>Manage Investors</h1>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Passport No.</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                    @foreach($investorList as $investor)
                        <tr>
                            <th>{{$investor->id}}</th>
                            <th>{{$investor->email}}</th>
                            <th>{{$investor->name}}</th>
                            <th>{{$investor->passport_num}}</th>
                            <th>{{$investor->dob->toFormattedDateString()}}</th>
                            <th>{{$investor->phone}}</th>
                            <th>{{$investor->created_at->toFormattedDateString()}}</th>
                            <th>
                                <a href="{{url('/admin/investor/show/'.$investor->id)}}" class="btn btn-xs btn-primary">View
                                    Details</a>

                            </th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
