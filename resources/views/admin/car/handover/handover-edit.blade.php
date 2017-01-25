@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Handover Form</h3>

            <form enctype="multipart/form-data" method="POST"
                  action="{{url('api/admin/contracts/'.$contract_id.'/handovers/'.$handover->id)}}">
                  <input type="hidden" name="_method" value="PUT">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="handover_type">HandOver Type</label>
                    @if(!$contract->hasOutHandover)
                        <div class="alert alert-info">
                            Must create a outgoing handover before an incoming handover. This will be an <strong>OUTGOING</strong>
                            handover. Outgoing means Car given to driver
                        </div>
                        {{--<input type="text" readonly class="form-control" id="handover_type" name='type' value="outgoing" placeholder="Type">--}}
                    @elseif(!$contract->hasInHandover)
                        <div class="alert alert-info">
                            An outgoing handover already exists. This will be an <strong>INCOMING</strong> handover.
                            Incoming means Car received from driver
                        </div>
                    @else
                        <div class="alert alert-info">
                            This contract has both handover forms attached, outgoing and incoming. You can't attach
                            another form with this contract
                        </div>
                    @endif
                </div>


                @if(!$contract->hasAllHandovers)
                    <div class="form-group">
                        <label for="handover_date">HandOver Date</label>
                        <input required="required" type="date" class="form-control" id="handover_date"
                               name="handover_date" placeholder="Date" value="{{old('handover_date') or $handover->date}}">
                    </div>

                    <div class="form-group">
                        <label for="handover_status">HandOver Status</label>
                        {{--<input type="text" class="form-control" id="handover_status"  name="status" placeholder="Status">--}}
                        {{ Form::select('status', ['pending'=>'Pending', 'completed'=>'Completed'],$handover->status,['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label for="handover_odo_meter_reading">Odo Meter Reading</label>
                        <input required="required" type="text" class="form-control" id="handover_odo_meter_reading"
                               name="odo_meter_reading"
                               placeholder="Odo Meter Reading" value="{{old('handover_date') or $handover->date}}">
                    </div>
                    <div class="form-group">
                        <label for="handover_comments">Comments</label>
                        <textarea class="form-control" id="handover_comments" name="comments">{{old('handover_date') or $handover->date}}</textarea>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="submit">
                @endif
            </form>
        </div>
    </div>
@endsection