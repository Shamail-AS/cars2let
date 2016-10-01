<div class="card">
    {{--<div class="card-header ongoing">--}}
        {{--<h1>Register a new driver</h1>--}}
    {{--</div>--}}
    <div class="card-body">
        <form class="form" method="POST" action="{{url('/investor/assets/driver/store')}}">
            {!! csrf_field() !!}
            {{--<div class="form-group {{$error->has('reg_no') ? 'has-error':''}}">--}}
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name" value="{{old('name')}}">
                {{--@if($error->has('reg_no'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('reg_no') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
            <div class="form-group">
                {{--                    <div class="form-group {{$error->has('make') ? 'has-error':''}}">--}}
                <label>License Number</label>
                <input class="form-control" type="text" name="license_no" value="{{old('license_no')}}">
                {{--@if($error->has('make'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('make') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
            <div class="form-group">
                {{--                    <div class="form-group {{$error->has('make') ? 'has-error':''}}">--}}
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="{{old('email')}}">
                {{--@if($error->has('make'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('make') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
            <div class="form-group">
                {{--                    <div class="form-group {{$error->has('make') ? 'has-error':''}}">--}}
                <label>Phone Number</label>
                <input class="form-control" type="text" name="phone" value="{{old('phone')}}">
                {{--@if($error->has('make'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('make') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
            <div class="form-group ">
                <label>Date of Birth</label>
                <input class="form-control dp" type="date" name="dob"
                       value="{{old('dob')}}">
            </div>

            <div class="form-group">
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>Register driver
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>