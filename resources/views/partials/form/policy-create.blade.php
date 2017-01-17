<div class="card">
    <div class="card-body">
        <form class="form" method="POST"
              action="{{url('/admin/insurance/store')}}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Policy Number</label>
                        <input placeholder="Number" class="form-control" type="text" name="policy_num"
                               value="{{old('policy_num')}}">

                    </div>
                    <div class="form-group">
                        <label>Insurance Company</label>
                        <select class="form-control" name="insurance_comp">
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Policy Start </label>
                        <input placeholder="2016-8-9" class="form-control dp" type="text" name="policy_start"
                               value="{{old('policy_start')}}">
                   </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Policy End</label>
                        <input placeholder="2016-8-9" class="form-control dp" type="text" name="policy_end"
                               value="{{old('policy_end')}}">

                    </div>
                    <div class="form-group">
                        <label>Excess</label>
                        <input placeholder="eg - 07418402842" class="form-control" type="text" name="excess"
                               value="{{old('excess')}}">

                    </div>
                    <div class="form-group ">
                        <label>Annual Insurance</label>
                        <input class="form-control" type="text" name="annual_insurance"
                               value="{{old('annual_insurance')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-btn fa-user"></i>Register Insurance
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>