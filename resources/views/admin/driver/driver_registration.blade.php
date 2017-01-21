@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3>Driver Registration for Car : {{$car_reg_no}}</h3>

        <form enctype="multipart/form-data" method="POST" action="{{url('drivers/store?car_reg_no='.$car_reg_no)}}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action active">
                            <center><h4>Personal Information</h4></center>
                        </a>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input  type="text" class="form-control" name="first_name" id="first_name" value="{{old('first_name')}}">
                        @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input  type="text" class="form-control" name="last_name" id="last_name" value="{{old('last_name')}}">
                        @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input  type="text" class="form-control" name="email" id="email" value="{{old('email')}}">
                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="dob">Date Of Birth</label>
                        <input  type="date" class="form-control" id="dob" name="dob" value="{{old('email')}}" placeholder="Date Of Birth">
                        @if ($errors->has('dob')) <p class="help-block">{{ $errors->first('dob') }}</p> @endif
                        
                    </div>
                    <div class="form-group">
                        <label for="passport">Passport Number</label>
                        <input  type="text" class="form-control" name="passport" id="passport" value="{{old('passport')}}">
                        @if ($errors->has('passport')) <p class="help-block">{{ $errors->first('passport') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="pass_exp_at">Passport Expiry</label>
                        <input  type="text" class="form-control" name="pass_exp_at" id="pass_exp_at" value="{{old('pass_exp_at')}}">
                        @if ($errors->has('pass_exp_at')) <p class="help-block">{{ $errors->first('pass_exp_at') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input  type="text" class="form-control" name="nationality" id="nationality" value="{{old('nationality')}}">
                        @if ($errors->has('nationality')) <p class="help-block">{{ $errors->first('nationality') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input  type="text" class="form-control" name="address" id="address" value="{{old('address')}}">
                        @if ($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input  type="text" class="form-control" name="mobile" id="mobile" value="{{old('mobile')}}">
                        @if ($errors->has('mobile')) <p class="help-block">{{ $errors->first('mobile') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="emergency_person">Emergency Contact Person</label>
                        <input  type="text" class="form-control" name="emergency_person" id="emergency_person" value="{{old('emergency_person')}}">
                        @if ($errors->has('emergency_person')) <p class="help-block">{{ $errors->first('emergency_person') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="emergency_no">Emergency No</label>
                        <input  type="text" class="form-control" name="emergency_no" id="emergency_no" value="{{old('emergency_no')}}">
                        @if ($errors->has('emergency_no')) <p class="help-block">{{ $errors->first('emergency_no') }}</p> @endif
                    </div>                    
                    <div class="form-group">
                        <label for="years_in_uk">No of Years in UK</label>
                        <input  type="text" class="form-control" name="years_in_uk" id="years_in_uk" value="{{old('years_in_uk')}}">
                        @if ($errors->has('years_in_uk')) <p class="help-block">{{ $errors->first('years_in_uk') }}</p> @endif
                    </div>
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action active">
                            <center><h4>My Employment</h4></center>
                        </a>
                    </div>                          
                    {{-- <div class="form-group">
                        <p><strong>Have you been employed/working as a PCO Driver before?</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="radio-inline">        
                                    <input type="radio" name="emp_year_radio" value="yes">Yes
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="emp_year_radio" value="no">No
                                </label>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <p><strong>Dates Employed/Worked* (YYYY-MM-DD)</strong></p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_from">From</label>
                                <input type="text" class="form-control" name="emp_from" id="emp_from" value="{{old('emp_from')}}">
                                @if ($errors->has('emp_from')) <p class="help-block">{{ $errors->first('emp_from') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_to">To</label>
                                <input  type="text" class="form-control" name="emp_to" id="emp_to" value="{{old('emp_to')}}">
                                @if ($errors->has('emp_to')) <p class="help-block">{{ $errors->first('emp_to') }}</p> @endif
                            </div>
                        </div>
                    </div> --}}
                    <p><strong>My Driving</strong></p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="curr_pco_num">Current PCO license No</label>
                                <input  type="text" class="form-control" name="curr_pco_num" id="curr_pco_num" value="{{old('curr_pco_num')}}">
                                @if ($errors->has('curr_pco_num')) <p class="help-block">{{ $errors->first('curr_pco_num') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="curr_pco_expiry">Expiry Date</label>
                                <input  type="text" class="form-control" name="curr_pco_expiry" id="curr_pco_expiry" value="{{old('curr_pco_expiry')}}">
                                @if ($errors->has('curr_pco_expiry')) <p class="help-block">{{ $errors->first('curr_pco_expiry') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="curr_driving_licence_no">Current Driving license No</label>
                                <input  type="text" class="form-control" name="curr_driving_licence_no" id="curr_driving_licence_no" value="{{old('curr_driving_licence_no')}}">
                                @if ($errors->has('curr_driving_licence_no')) <p class="help-block">{{ $errors->first('curr_driving_licence_no') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="curr_licence_expiry">Driving Licence Expiry</label>
                                <input  type="text" class="form-control" name="curr_driving_expiry" id="curr_driving_expiry" value="{{old('curr_driving_expiry')}}">
                                @if ($errors->has('curr_driving_expiry')) <p class="help-block">{{ $errors->first('curr_driving_expiry') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_of_years_driving">No Of Years Driving</label>
                                <input  type="text" class="form-control" name="no_of_years_driving" id="no_of_years_driving" value="{{old('no_of_years_driving')}}">
                                @if ($errors->has('no_of_years_driving')) <p class="help-block">{{ $errors->first('no_of_years_driving') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <p><strong>Have you had any driving accidents/convictions in the last 3 years?</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="radio-inline">        
                                    <input type="radio" name="driving_acc_radio"  value="yes">Yes
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="driving_acc_radio" value="no">No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail_of_conviction">If YES, please give brief details</label>
                        <textarea class="form-control" name="detail_of_conviction"> </textarea>
                    </div> --}}
                </div>    
                <div class="col-md-6">
                    <div class="form-group">
                        <p><strong>Have you had any endorsements/penalty points in the last 3 years? </strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="radio-inline">        
                                    <input type="radio" name="penelty_points_radio" value="yes">Yes
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="penelty_points_radio" value="no">No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="penelty_points">If YES, state number of penelty points</label>
                        <input class="form-control" id="penelty_points" name="penelty_points" value="{{old('penelty_points')}}" >
                        @if ($errors->has('penelty_points')) <p class="help-block">{{ $errors->first('penelty_points') }}</p> @endif
                    </div>
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action active">
                            <center><h4>Any Convictions</h4></center>
                        </a>
                    </div>
                    <h3>Important Information</h3>
                    <p>
                        PLEASE NOTE THAT APPLICATION FOR PCO VEHICLE HIRE REQUIRE A FULL CRIMINAL HISTORY DISCLOSURE.
                    </p>
                    <p>
                      In the event of a successful application a Disclosure and Barring Service Check will be carried out for this position however having a criminal record will not necessarily prevent any agreement to be entered into. The disclosure and barring service has a code of practice which Cars2Let adheres to.   
                    </p>                            
                    <p><strong>Have you ever been convicted of a criminal offence? </strong></p>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="radio-inline">        
                                <input type="radio" name="criminal_radio" value="yes">Yes
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="radio-inline">
                                <input type="radio" name="criminal_radio" value="no">No
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="conv_date">Date (YYYY-MM-DD)</label>
                                <input type="text" class="form-control" name="conv_date" id="conv_date" value="{{old('conv_date')}}">
                                @if ($errors->has('conv_date')) <p class="help-block">{{ $errors->first('conv_date') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="conv_place">Place</label>
                                <input  type="text" class="form-control" name="conv_place" id="conv_place" value="{{old('conv_place')}}">
                                @if ($errors->has('conv_place')) <p class="help-block">{{ $errors->first('conv_place') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="detail_of_conviction">If YES, brief details of endorsements/penalties</label>
                            <textarea class="form-control" name="detail_of_conviction"> {{old('detail_of_conviction')}}</textarea>
                            @if ($errors->has('detail_of_conviction')) <p class="help-block">{{ $errors->first('detail_of_conviction') }}</p> @endif
                        </div>

                    </div>
                    <div class="form-group">
                        <p><strong>Should you not have a copy of a recent DBS check, do you give permission to Cars2Let to run a DBS Check </strong></p>
                        <div class="row">
                            <div class="col-md-6">
                            <label class="radio-inline">        
                                <input type="radio" name="dbs_radio" value="yes">Yes
                            </label>
                            </div>
                            <div class="col-md-6">
                            <label class="radio-inline">
                                <input type="radio" name="dbs_radio" value="no">No
                            </label>
                            </div>
                            @if ($errors->has('dbs_radio')) <p class="help-block">{{ $errors->first('dbs_radio') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-file">
                            Driving Licence
                            <input type="file" id="file" name="driving_licence_file[]" multiple>
                        </label>
                        @if ($errors->has('driving_licence_file')) <p class="help-block">{{ $errors->first('driving_licence_file') }}</p> @endif
                        <label class="custom-file">
                            PCO Licence
                            <input type="file" id="file" name="pco_licence_file[]" multiple>
                            @if ($errors->has('pco_licence_file')) <p class="help-block">{{ $errors->first('pco_licence_file') }}</p> @endif
                        </label>
                        <label class="custom-file">
                            Passport
                            <input type="file" id="file" name="passport_file[]" multiple>
                            @if ($errors->has('passport_file')) <p class="help-block">{{ $errors->first('passport_file') }}</p> @endif
                        </label>
                        <label class="custom-file">
                            CRB/DBS Certificate
                            <input type="file" id="file" name="crb_file[]" multiple>
                            @if ($errors->has('crb_file')) <p class="help-block">{{ $errors->first('crb_file') }}</p> @endif
                        </label>
                        <label class="custom-file">
                            Proof Of Address
                            <input type="file" id="file" name="address_file[]" multiple>
                            @if ($errors->has('address_file')) <p class="help-block">{{ $errors->first('address_file') }}</p> @endif
                        </label>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action active">
                            <center><h4>Contract Details</h4></center>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="con_start_date">Contract Start Date (YYYY-MM-DD)</label>
                                <input type="text" class="form-control" name="con_start_date" id="con_start_date" value="{{old('con_start_date')}}">
                                @if ($errors->has('con_start_date')) <p class="help-block">{{ $errors->first('con_start_date') }}</p> @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="con_end_date">Contract End Date (YYYY-MM-DD)</label>
                                <input type="text" class="form-control" name="con_end_date" id="con_end_date" value="{{old('con_end_date')}}">
                                @if ($errors->has('con_end_date')) <p class="help-block">{{ $errors->first('con_end_date') }}</p> @endif
                            </div>
                        </div> 
                    </div>
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action active">
                            <center><h4>I Declare</h4></center>
                        </a>
                    </div>
                    <p>By clicking on the “ I agree” button you are confirming that the facts set out in this application for private vehicle hire are, to the best of my knowledge, true and complete. I understand that if I entered into an agreement, and it is subsequently found that I have failed to give correct information or failed to declare any material fact, this could lead to termination of agreement without notice</p>
                    <label class="radio-inline">
                        <input type="radio" name="agree_radio">I Agree
                    </label>
                    @if ($errors->has('agree_radio')) <p class="help-block">{{ $errors->first('agree_radio') }}</p> @endif
                    <div class="g-recaptcha" data-sitekey="6Ld39AkUAAAAAGYjkCoGBhwtofGD10eiLHGEvDah"></div>
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>                        
            </div>
        </form>
    </div>   
</div>
@endsection
@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style type="text/css">
        .help-block{
            color:red;
        }
    </style>
@endsection