<div id="wrapper" ng-controller="ticketsController">
        <h1>Tickets</h1>
        <hr>
        <div id="tickets">
            @include('partials.admin.car.new-ticket')
            <button class="btn btn-primary btn-block" ng-click="newTicket()"> New Ticket</button>
            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Ticket Num</th>
                    {{--<th>Car</th>--}}
                    <th>Driver</th>
                    <th>Latest Due Date</th>
                    <th>Status</th>
                    <th>Actual Due Date</th>
                    <th>Incident Date</th>
                    <th>Date Of Notice</th>
                    <th>Type</th>
                    <th>Website</th>
                    <th>Paid Date</th>
                    <th>Amount</th>
                    <th>Payment Reference</th>
                    <th>Liability Of</th>
                    <th>Case Handler</th>
                    <th>Payment Account</th>
                    <th>Authorized By</th>
                    <th>Comments</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="ticket in vm.tickets">
                    <td>@{{ ticket.ticket_num }}</td>
                    {{--                    <td>@{{ ticket.car.reg_no }}</td>--}}
                    <td>@{{ ticket.driver.name }}</td>
                    <td>@{{ formatDate(ticket.latest_due_date) }}</td>
                    <td>@{{ ticket.status }}</td>
                    <td>@{{ formatDate(ticket.actual_due_date) }}</td>

                    <td>@{{ formatDate(ticket.incident_dt) }}</td>
                    <td>@{{ formatDate(ticket.date_of_notice) }}</td>
                    <td>@{{ ticket.type }}</td>
                    <td>@{{ ticket.website }}</td>
                    <td>@{{ formatDate(ticket.paid_date) }}</td>
                    <td>@{{ ticket.amount }}</td>
                    <td>@{{ ticket.payment_reference }}</td>
                    <td>@{{ ticket.liability_of }}</td>
                    <td>@{{ ticket.case_handler }}</td>
                    <td>@{{ ticket.payment_account }}</td>
                    <td>@{{ ticket.authorized_by }}</td>
                    <td>@{{ ticket.comments }}</td>
                    
                    <td>
                        <a class="btn btn-xs btn-info" href="{{url('admin/tickets')}}/@{{ ticket.id }}">Images</a>
                        <button class="btn btn-xs btn-primary" ng-click="editTicket(ticket)">Edit</button>
                        <button class="btn btn-xs btn-danger" ng-click="deleteTicket(ticket)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
            </div>
            </div>  
        </div>
    </div>