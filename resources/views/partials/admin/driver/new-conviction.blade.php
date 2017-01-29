<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create new Conviction</h4>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" action="{{url("admin/driver/".$driver->id."/convictions")}}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Conviction Detail</label>
                                    <input name="details" id="details" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penelty Points</label>
                                    <input name="penalty_points" id="penalty_points" class="form-control">
                                </div>
                            </div>
                        </div>       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Convicted At</label>
                                    {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" name="convicted_at" id="convicted_at" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Place</label>
                                    <input name="place" id="place" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

