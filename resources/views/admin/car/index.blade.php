@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="container">
        <div class="add-btn">
            <a href="{{url('admin/car/create')}}" class="nostyle">
                <i class="fa fa-plus fa-2x"></i>
            </a>
        </div>

        <h1>Manage Cars</h1>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Registration</th>
                        <th>Comments</th>
                        <th></th>
                    </tr>
                    @foreach($carList as $car)
                        <tr>
                            <th>{{$car->id}}</th>
                            <th>{{$car->make}}</th>
                            <th>{{$car->reg_no}}</th>
                            <th>{{$car->comments}}</th>
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