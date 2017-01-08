<div class="row">
    <div class="col-md-6">
        <form method="post" action="{{url('/api/admin/' . $contract->id.'/handovers/create')}}">
            <div class="form-group">
                <select name="driver" class="form-control">
                    @foreach($drivers as $driver)
                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                </select>
            </div>

            <div class="form-group">
                <label>Handover Date</label>
                {{--<input ng-model="ticket.incident_dt" type="text" class="form-control">--}}
                <input type="text" class="form-control" uib-datepicker-popup name="handover_date"/>
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" name="type" class="form-control">
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="text" name="status" class="form-control">
            </div>

            <div class="form-group">
                <label>Odo Meter Reading</label>
                <input type="text" name="status" class="form-control">
            </div>

            <div class="form-group">
                <label>Comments</label>
                <textarea name="comments" class="form-control"></textarea>
            </div>
        </form>
    </div>
</div>

                    