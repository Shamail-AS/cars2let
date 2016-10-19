<div class="card">
    <div class="card-body">
        <form class="form" role="form" method="POST" action="{{url("/admin/investor/store")}}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="name" placeholder="" required="true">
                    </div>
                    <div class="form-group">
                        <label>Investor email</label>
                        <input class="form-control" type="text" name="email" placeholder="someone@example.com"
                               required="true">
                    </div>
                    <div class="form-group">
                        <label>Passport Number</label>
                        <input class="form-control" type="text" name="passport_num" placeholder="" required="true">
                    </div>
                    <div class="form-group">
                        <label>Date of birth</label>
                        <input class="form-control dp" type="date" name="dob" placeholder="mm-dd-yyyy" required="true">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Mobile Phone</label>
                        <input class="form-control" type="tel" pattern='\d{11}' name="phone"
                               placeholder="Format: 099999999">
                    </div>
                    <div class="form-group">
                        <label>Car Track URL</label>
                        <input class="form-control" type="url" name="tracking_url" placeholder="" required="true">
                    </div>
                    <div class="form-group">
                        <label>Accounting Period Start</label>
                        <input class="form-control dp" type="date" name="acc_start" placeholder="Start" required="true">
                    </div>
                    <div class="form-group">
                        <label>Accounting Period End</label>
                        <input class="form-control dp" type="date" name="acc_end" placeholder="End" required="true">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-primary btn-block" type="submit">
                        <i class="fa fa-btn fa-user"></i>Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

