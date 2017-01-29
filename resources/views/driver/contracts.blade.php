@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    
@endsection

@section("content")
    <div class="container">
    <div class="wrapper">
        <h1>Approved Contracts</h1>
            {{ csrf_field() }}
        <table class="table table-striped" id="drivers">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Car Reg No</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Rent</th>  
                </tr>
            </thead>
            
            <tbody>
                @forelse($driver->contracts as $contract)
                    @if($contract->approved_by != null)
                <tr>
                    <td><span style="margin-right: 10px">
                        @if($contract->status == 1)
                        <i class="fa fa-circle ongoing"></i>
                        @elseif($contract->status == 2)
                        <i class="fa fa-circle new"></i>
                        @elseif($contract->status == 3)
                        <i ng-if="contract.status == 3" class="fa fa-circle terminated"></i>
                        @elseif($contract->status == 4)
                        <i ng-if="contract.status == 4" class="fa fa-circle complete"></i>
                        @endif
                    </span></td>
                    <td>{{$contract->car['reg_no']}}</td>
                    <td>{{ $contract->start_date}}</td>
                    <td>{{ $contract->end_date}}</td>
                    <td>{{$contract->car['price']}}</td>
                </tr>
                    @else 
                        <?php continue; ?>
                    @endif
                @empty
                <td>No Record</td>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


@endsection
