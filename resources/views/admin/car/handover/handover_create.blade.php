@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12">
                <h3>Upload Files</h3>
                <form enctype="multipart/form-data" method="POST" action="{{url('api/admin/contracts/'.$contract_id.'/handovers/')}}"> 
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="handover_date">HandOver Date</label>
                        <input type="date" class="form-control" id="handover_date" name="handover_date"  placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="handover_type">HandOver Type</label>
                        <input type="text" class="form-control" id="handover_type" name='type' placeholder="Status">
                    </div>
                    <div class="form-group">
                        <label for="handover_status">HandOver Status</label>
                        <input type="text" class="form-control" id="handover_status"  name="status" placeholder="Status">
                    </div>
                    <div class="form-group">
                        <label for="handover_odo_meter_reading">Odo Meter Reading</label>
                        <input type="text" class="form-control" id="handover_odo_meter_reading"  name="odo_meter_reading" placeholder="Odo Meter Reading">
                    </div>
                    <div class="form-group">
                        <label for="handover_comments">Comments</label>
                        <textarea class="form-control" id="handover_comments" name="comments"></textarea>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="submit">
                </form>
            </div>
        </div>
    </div>

@endsection