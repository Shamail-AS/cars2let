@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.steps.css')}}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">
     
@endsection

@section('content')
    <br>
    <div class="container">
        
        <form method="post" action="{{url('drivers/store?car_reg_no='.$car->reg_no)}}" id="driver-form" enctype="multipart/form-data"> 
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                        <h2>Contract Dates</h2>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Car Registration: {{$car->reg_no}}</h3>
                                </div>
                                <div class="col-md-6">
                                    <h3>Rental Price: GBP:{{$car->price or 10}}/week</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <div class='input-group date'>
                                            <input type='text' id='start_date' name="start_date" class="form-control" value="{{old('start_date')}}" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @if ($errors->has('start_date')) <p class="help-block">{{ $errors->first('start_date') }}</p> @endif
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max">End Date</label>
                                        <div class='input-group date' >
                                            <input type='text' id='end_date' name="end_date" class="form-control" value="{{old('end_date')}}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @if ($errors->has('end_date')) <p class="help-block">{{ $errors->first('end_date') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>PERSONAL INFORMATION</h2>
                        <section>
                            <div class="row">
                                <div class="col-md-3">
                                   <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type='text' id='name' name="name" class="form-control" value="{{old('name')}}"/>
                                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                    </div> 

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type='text' id='email' name="email" class="form-control" value="{{old('email')}}"/>
                                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type='text' id='phone' name="phone" class="form-control" value="{{old('phone')}}"/>
                                        @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth</label>
                                        <input type='text' id='dob' name="dob" class="form-control" value="{{old('dob')}}"/>
                                        @if ($errors->has('dob')) <p class="help-block">{{ $errors->first('dob') }}</p> @endif
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type='password' id='password' name="password" class="form-control"/>
                                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="address">Car Parking Address</label>
                                        <input type='text' id='address' name="address" class="form-control" value="{{old('address')}}"/>
                                        @if ($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post_code">Post Code</label>
                                        <input type='text' id='post_code' name="post_code" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="alt_address">Alternative Car Parking Address</label>
                                        <input type='text' id='alt_address' name="alt_address" class="form-control" value="{{old('alt_address')}}"/>
                                        @if ($errors->has('alt_address')) <p class="help-block">{{ $errors->first('alt_address') }}</p> @endif
                                        
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alt_post_code">Post Code</label>
                                        <input type='text' id='alt_post_code' name="alt_post_code" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        Upload Passport
                                        <input type="file" id="passport" name="passport" >
                                        @if ($errors->has('passport')) <p class="help-block">{{ $errors->first('passport') }}</p> @endif
                                        
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        Upload Proof of Address (Bank Statement, Utility Bill)
                                        <input type="file" id="proof" name="proof">
                                        @if ($errors->has('proof')) <p class="help-block">{{ $errors->first('proof') }}</p> @endif
                                    </label>
                                </div>
                            </div>
                        </section>

                        <h2>Driving Information</h2>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="driving_licence_start_date">Driving Licence Start Date</label>
                                        <div class='input-group date'>
                                            <input type='text' id='driving_licence_start_date' name="driving_licence_start_date" class="form-control" value="{{old('driving_licence_start_date')}}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @if ($errors->has('driving_licence_start_date')) <p class="help-block">{{ $errors->first('driving_licence_start_date') }}</p> @endif

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nino">National Insurance Number</label>
                                        <input type='text' id='nino' name="nino" class="form-control" value="{{old('nino')}}"/>
                                    </div>
                                    @if ($errors->has('nino')) <p class="help-block">{{ $errors->first('nino') }}</p> @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Driving Licence
                                            <input type="file" id="driving_licence" name="driving_licence" >
                                        </label>
                                        @if ($errors->has('driving_licence')) <p class="help-block">{{ $errors->first('driving_licence') }}</p> @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label>
                                            PCO Licence
                                            <input type="file" id="pco_licence" name="pco_licence">
                                        </label>
                                        @if ($errors->has('pco_licence')) <p class="help-block">{{ $errors->first('pco_licence') }}</p> @endif

                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="driving_mini_cab_from">Driving Mini Cab From</label>
                                        <div class='input-group date'>
                                            <input type='text' id='driving_mini_cab_from' name="driving_mini_cab_from" class="form-control" value="{{old('driving_mini_cab_from')}}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        @if ($errors->has('driving_mini_cab_from')) <p class="help-block">{{ $errors->first('driving_mini_cab_from') }}</p> @endif

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uber_rating" class="control-label">Uber Rating</label>
                                        <input id="uber_rating" name="uber_rating" class="form-control" value="{{old('uber_rating')}}">
                                        @if ($errors->has('uber_rating')) <p class="help-block">{{ $errors->first('uber_rating') }}</p> @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>Questions</h2>
                        <section>
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label for="comments" class="control-label">Questions or Requests</label>
                                        <textarea class="form-control" name="comments" id="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </form>
    </div>     


@endsection
@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
    
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    
    <script type="text/javascript" src="{{asset('js/jquery.steps.min.js')}}"></script>
    <style type="text/css">
        .help-block{
            color:red;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                onFinished: function (event, currentIndex)
                    {
                        var form = $("#driver-form");
                         
                        // Submit form input
                        form.submit();
                    }
            });
            $("#start_date").datetimepicker({format:"YYYY-MM-DD"});
            $("#end_date").datetimepicker({
                useCurrent: false,
                format:"YYYY-MM-DD"     
            });
            $("#start_date").on("dp.change", function (e) {
                $("#end_date").data("DateTimePicker").minDate(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $("#start_date").data("DateTimePicker").maxDate(e.date);
            });
            $("#driving_licence_start_date").datetimepicker({format:"YYYY-MM-DD"});
            $("#dob").datetimepicker({format:"YYYY-MM-DD"});
            $("#driving_mini_cab_from").datetimepicker({format:"YYYY-MM-DD"});


            // IMPORTANT: You must call .steps() before calling .formValidation()
            // $('#profileForm')
            //     .steps({
            //         headerTag: 'h2',
            //         bodyTag: 'section',
            //         onStepChanged: function(e, currentIndex, priorIndex) {
            //             // You don't need to care about it
            //             // It is for the specific demo
            //             adjustIframeHeight();
            //         },
            //         // Triggered when clicking the Previous/Next buttons
            //         onStepChanging: function(e, currentIndex, newIndex) {
            //             var fv         = $('#profileForm').data('formValidation'), // FormValidation instance
            //                 // The current step container
            //                 $container = $('#profileForm').find('section[data-step="' + currentIndex +'"]');

            //             // Validate the container
            //             fv.validateContainer($container);

            //             var isValidStep = fv.isValidContainer($container);
            //             if (isValidStep === false || isValidStep === null) {
            //                 // Do not jump to the next step
            //                 return false;
            //             }

            //             return true;
            //         },
            //         // Triggered when clicking the Finish button
            //         onFinishing: function(e, currentIndex) {
            //             var fv         = $('#profileForm').data('formValidation'),
            //                 $container = $('#profileForm').find('section[data-step="' + currentIndex +'"]');

            //             // Validate the last step container
            //             fv.validateContainer($container);

            //             var isValidStep = fv.isValidContainer($container);
            //             if (isValidStep === false || isValidStep === null) {
            //                 return false;
            //             }

            //             return true;
            //         },
            //         onFinished: function(e, currentIndex) {
            //             // Uncomment the following line to submit the form using the defaultSubmit() method
            //             // $('#profileForm').formValidation('defaultSubmit');

            //             // For testing purpose
            //             $('#welcomeModal').modal();
            //         }
            //     })
            //     .formValidation({
            //         framework: 'bootstrap',
            //         icon: {
            //             valid: 'glyphicon glyphicon-ok',
            //             invalid: 'glyphicon glyphicon-remove',
            //             validating: 'glyphicon glyphicon-refresh'
            //         },
            //         // This option will not ignore invisible fields which belong to inactive panels
            //         excluded: ':disabled',
            //         fields: {
            //             username: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The username is required'
            //                     },
            //                     stringLength: {
            //                         min: 6,
            //                         max: 30,
            //                         message: 'The username must be more than 6 and less than 30 characters long'
            //                     },
            //                     regexp: {
            //                         regexp: /^[a-zA-Z0-9_\.]+$/,
            //                         message: 'The username can only consist of alphabetical, number, dot and underscore'
            //                     }
            //                 }
            //             },
            //             email: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The email address is required'
            //                     },
            //                     emailAddress: {
            //                         message: 'The input is not a valid email address'
            //                     }
            //                 }
            //             },
            //             password: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The password is required'
            //                     },
            //                     different: {
            //                         field: 'username',
            //                         message: 'The password cannot be the same as username'
            //                     }
            //                 }
            //             },
            //             confirmPassword: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The confirm password is required'
            //                     },
            //                     identical: {
            //                         field: 'password',
            //                         message: 'The confirm password must be the same as original one'
            //                     }
            //                 }
            //             },
            //             firstName: {
            //                 row: '.col-xs-4',
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The first name is required'
            //                     },
            //                     regexp: {
            //                         regexp: /^[a-zA-Z\s]+$/,
            //                         message: 'The first name can only consist of alphabetical and space'
            //                     }
            //                 }
            //             },
            //             lastName: {
            //                 row: '.col-xs-4',
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The last name is required'
            //                     },
            //                     regexp: {
            //                         regexp: /^[a-zA-Z\s]+$/,
            //                         message: 'The last name can only consist of alphabetical and space'
            //                     }
            //                 }
            //             },
            //             gender: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The gender is required'
            //                     }
            //                 }
            //             },
            //             dob: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'The birthday is required'
            //                     },
            //                     date: {
            //                         format: 'YYYY/MM/DD',
            //                         message: 'The birthday is not valid'
            //                     }
            //                 }
            //             },
            //             bio: {
            //                 validators: {
            //                     stringLength: {
            //                         max: 200,
            //                         message: 'The bio must be less than 200 characters'
            //                     }
            //                 }
            //             }
            //         }
            //     });
        });
    </script>
@endsection