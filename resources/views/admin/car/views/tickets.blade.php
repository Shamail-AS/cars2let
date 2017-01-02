<div>
    <div id="wrapper" ng-controller="ticketsController">
        <h1><a href="{{url('/admin/car/all')}}"><i class="fa fa-chevron-circle-left"></i> All Cars
            </a> / Tickets</h1>
        <hr>
        <div id="tickets">
            @include('partials.admin.car.new-ticket')
            <button class="btn btn-primary btn-block" ng-click="newTicket()"> New Ticket</button>
            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Ticket Num</th>
                    {{--<th>Car</th>--}}
                    <th>Driver</th>
                    <th>Type</th>
                    <th>Source(Cause)</th>
                    <th>Happened On</th>
                    <th>Issued On</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Comments</th>
                    <th>Images</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="ticket in vm.tickets">
                    <td>@{{ ticket.ticket_num }}</td>
                    {{--                    <td>@{{ ticket.car.reg_no }}</td>--}}
                    <td>@{{ ticket.driver.name }}</td>
                    <td>@{{ ticket.type }}</td>
                    <td>@{{ ticket.cause }}</td>
                    <td>@{{ formatDate(ticket.incident_dt) }}</td>
                    <td>@{{ formatDate(ticket.issue_dt) }}</td>
                    <td>@{{ ticket.amount }}</td>
                    <td>@{{ ticket.status }}</td>
                    <td>@{{ ticket.comments }}</td>
                    <td>
                        <a class="btn btn-xs btn-info" href="{{url('admin/tickets')}}/@{{ ticket.id }}">Images</a>
                        <button class="btn btn-xs btn-primary" ng-click="editTicket(ticket)">Edit</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>