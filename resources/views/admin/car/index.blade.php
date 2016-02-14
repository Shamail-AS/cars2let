@extends("layouts.app")

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Registration</th>
                        <th></th>
                    </tr>
                    @foreach($carList as $car)

                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection