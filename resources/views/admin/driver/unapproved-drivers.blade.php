@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#drivers").DataTable();
        });
    </script>
@endsection

@section("content")
    <div class="container">
    <div class="wrapper">
        <h1>Approve Drivers</h1>
        <form action="{{url('admin/unapproved/many')}}" method="POST">
            {{ csrf_field() }}
        <table class="table table-striped" id="drivers">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Car Reg No </th>
                    <th>Price </th>
                    <th>Driving Licence Issue</th>
                    <th>Date Of Birth</th>
                    <th>Contract Start Date</th>
                    <th>Contract End Date</th>
                    <th>Action</th>  
                </tr>
            </thead>
            
            <tbody>
                @forelse($unapprovedContracts as $contract)
                <tr>
                    <td><input type="checkbox" name="contracts[]" value="{{$contract->id}}"></td>
                    <td>{{ $contract->driver['name']}}</td>
                    <td>{{ $contract->driver['phone'] }}</td>
                    <td>{{ $contract->driver['email'] }}</td>
                    <td>{{$contract->car['reg_no']}}</td>
                    <td>{{$contract->car['price']}}</td>
                    <td>{{ $contract->driver['driving_licence_start_date'] }}</td>
                    <td>{{$contract->driver['dob']}}</td>
                    <td>{{ $contract->start_date}}</td>
                    <td>{{ $contract->end_date}}</td>
                    

                    <td><a href="{{url('admin/unapproved/'.$contract->id)}}" class="btn btn-success"> Details</a></td>
                </tr>
                @empty
                <td>No Record</td>
                @endforelse
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                    <button type="submit" class="btn btn-success">Unpprove Selected</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>


@endsection
