<div>
    <div id="wrapper">
        <h1>Convictions</h1>
        <hr>
        <div id="convictions">
            @include('partials.admin.driver.new-conviction')
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
                New Conviction
            </button>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    {{--<th>Car</th>--}}
                    <th>Ticket Id</th>
                    <th>Details</th>
                    <th>Penalty Points</th>
                    <th>Convicted At</th>
                    <th>Place</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($driver->convictions as $conviction)
                    <tr>
                        <td>{{$conviction->id}}</td>
                        <td>@if($conviction->ticket){{$conviction->ticket->ticket_num}}@endif</td>
                        <td>{{$conviction->details}}</td>
                        <td>{{$conviction->penalty_points}}</td>
                        <td>{{$conviction->convicted_at}}</td>
                        <td>{{$conviction->place}}</td>
                        <td class="no-wrap">
                            <button type="button" class="btn btn-danger btn-xs" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="{{url('admin/driver/'.$driver->id.'/convictions/'.$conviction->id.'/delete')}}" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                    '><i class="entypo-cancel"></i>Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>