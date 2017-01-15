@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper">
        <h1>Approve Drivers</h1>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Name</th>
                <th>License No.</th>
                <th>PCO License No.</th>
                <th>DOB</th>
                <th>Phone</th>
                <th></th>
                <th></th>
            </tr>

            @forelse($unapprovedContracts as $contract)
            <tr>
                <td>{{ $contract->driver['id'] }}</td>
                <td>{{ $contract->driver['email'] }}</td>
                <td>{{ $contract->driver['name']}}</td>
                <td>{{ $contract->driver['license_no'] }}</td>
                <td>{{ $contract->driver['pco_license_no'] }}</td>
                <td>{{$contract->driver['dob']}}</td>
                <td>{{ $contract->driver['phone'] }}</td>
                <td><a href="{{url('admin/unapproved/'.$contract->id)}}" class="btn btn-success"> Details</a></td>
            </tr>
            @empty
            <td>No Record</td>
            @endforelse
        </table>
    </div>


@endsection