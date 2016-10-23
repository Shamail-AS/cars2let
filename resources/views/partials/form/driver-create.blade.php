<div class="card">
    <div class="card-body">
        <form class="form" method="POST"
              action="{{url($admin == true ? '/admin/driver/store' :'/investor/assets/driver/store')}}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input placeholder="John Doe" class="form-control" type="text" name="name"
                               value="{{old('name')}}">

                    </div>
                    <div class="form-group">
                        <label>License Number</label>
                        <input placeholder="AV123CD" class="form-control" type="text" name="license_no"
                               value="{{old('license_no')}}">
                    </div>
                    <div class="form-group">
                        <label>PCO License Number</label>
                        <input placeholder="AV123CD" class="form-control" type="text" name="pco_license_no"
                               value="{{old('pco_license_no')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input placeholder="someone@example.com" class="form-control" type="email" name="email"
                               value="{{old('email')}}">

                    </div>
                    <div class="form-group">
                        <label>Mobile Phone</label>
                        <small>No country code</small>
                        <input placeholder="eg - 07418402842" class="form-control" type="text" name="phone"
                               value="{{old('phone')}}">

                    </div>
                    <div class="form-group ">
                        <label>Date of Birth</label>
                        <input class="form-control dp" type="date" name="dob"
                               value="{{old('dob')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-btn fa-user"></i>Register driver
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>