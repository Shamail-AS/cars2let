@extends('layouts.app')

@section('styles')
     {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">
 --}}
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">

@endsection

@section('content')

    <div class="row" ng-app="cars2let">
        <div class="col-md-2">
            <div id="left-side-bar" ng-controller="detailsController">
                <div class="overflow flex-container col">
                    <div class="pre-body">
                        <h3><a href="{{url('/admin/driver/all')}}"><i class="fa fa-chevron-circle-left"></i> All
                            </a>/Driver Details</h3>
                        <hr>
                    </div>

                    <div class="main-body">
                        <div ng-show="vm.loading" class="modal-cover">
                            <i class="fa fa-spinner fa-5x fa-spin"></i>
                        </div>

                        <div class="form-group">
                            <label>Licence Number</label>
                            <input class="form-control" type="text" ng-model="vm.driver.license_no">
                        </div>
                        <div class="form-group">
                            <label>PCO License No</label>
                            <input class="form-control" type="text" ng-model="vm.driver.pco_license_no">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" ng-model="vm.driver.email">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" ng-model="vm.driver.name">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" type="text" ng-model="vm.driver.phone">
                        </div>
                        <div class="form-group">
                            <label>Dob</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_dob"
                                   is-open="vm.driver.dob_open" datepicker-options="dateOptions.dob"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.dob_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" type="text" ng-model="vm.driver.phone">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input class="form-control" type="text" ng-model="vm.driver.address">
                        </div>
                        <div class="form-group">
                            <label>Alternative Address</label>
                            <input class="form-control" type="text" ng-model="vm.driver.alt_address">
                        </div>
                        <div class="form-group">
                            <label>Passport No </label>
                            <input class="form-control" type="text" ng-model="vm.driver.passport">
                        </div>
                        <div class="form-group">
                            <label>Passport Expiry At</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_pass_exp_at"
                                   is-open="vm.driver.pass_exp_at_picker_open"
                                   datepicker-options="dateOptions.pass_exp_at"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.pass_exp_at_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Nationality</label>
                            <input class="form-control" type="text" ng-model="vm.driver.nationality">
                        </div>
                        <div class="form-group">
                            <label>Emergency Person</label>
                            <input class="form-control" type="text" ng-model="vm.driver.emerg_person">
                        </div>
                        <div class="form-group">
                            <label>Emergency Number</label>
                            <input class="form-control" type="text" ng-model="vm.driver.emerg_num">
                        </div>
                        <div class="form-group">
                            <label>Years In Uk</label>
                            <input class="form-control" type="text" ng-model="vm.driver.years_in_uk">
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <input class="form-control" type="text" ng-model="vm.driver.type">
                        </div>
                        <div class="form-group">
                            <label>National Insurance Number</label>
                            <input class="form-control" type="text" ng-model="vm.driver.nino">
                        </div>
                        <div class="form-group">
                            <label>Right To Work</label>
                            <input class="form-control" type="text" ng-model="vm.driver.right_to_work">
                        </div>
                        <div class="form-group">
                            <label>Driving Licence Start Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_driving_licence_start_date"
                                   is-open="vm.driver.driving_licence_start_date_picker_open"
                                   datepicker-options="dateOptions.driving_licence_start_date"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.driving_licence_start_date_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Driving Licence Expiry Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_licence_exp_at"
                                   is-open="vm.driver.licence_exp_at_picker_open"
                                   datepicker-options="dateOptions.licence_exp_at"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.licence_exp_at_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Pco Expiry Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_pco_expires_at"
                                   is-open="vm.driver.pco_expires_at_picker_open"
                                   datepicker-options="dateOptions.pco_expires_at"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.pco_expires_at_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Driving Mini Cab From</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.driver.x_driving_mini_cab_from"
                                   is-open="vm.driver.driving_mini_cab_from_picker_open"
                                   datepicker-options="dateOptions.driving_mini_cab_from"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.driver.driving_mini_cab_from_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Uber Rating</label>
                            <input class="form-control" type="text" ng-model="vm.driver.uber_rating">
                        </div>
                        <div class="form-group">
                            <label>Bank Account Id</label>
                            <input class="form-control" type="text" ng-model="vm.driver.bank_account_id">
                        </div>
                        <div class="form-group">
                            <label>Pay Method</label>
                            <input class="form-control" type="text" ng-model="vm.driver.pay_method">
                        </div>
                        <div class="form-group">
                            <label>On System Since</label>

                            <p class="">@{{ formatDate(vm.driver.created_at) }}</p>
                        </div>

                        @if(Auth::user()->isEditOnly)
                            <button ng-click="updateDriver(vm.driver)" class="btn btn-block btn-success">
                                Update
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="mid-section">
                @include('admin.driver.views.'.$page)
            </div>
        </div>
        <div class="col-md-2">
            <div id="right-side-bar" ng-controller="detailsController">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/driver/'.$driver->id)}}">Notifications</a></li>
                    {{--                    <li class="list-group-item"><a href="{{url('admin/driver/'.$driver->id.'/view/contracts')}}">Contracts</a>--}}
                    </li>
                    {{-- <li class="list-group-item"><a href="{{url('admin/driver/'.$driver->id.'/tickets')}}">Tickets</a> --}}
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/driver/'.$driver->id.'/convictions')}}">Convictions</a>
                    </li>
                    
                    {{-- Addding driver files upload --}}
                    <li class="list-group-item"><a href="{{url('admin/driver/'.$driver->id.'/files')}}">Upload and View Files</a>
                    </li>
                </ul>
                <div id="comments">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="message" rows="2" cols="50" class="form-control" placeholder="Comments"
                                  ng-model="vm.driver.comments">
                        </textarea>
                    </div>
                    <button class="btn btn-primary pull-right" ng-click="saveSelective(vm.driver,'comments')">Save
                        Comments
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    
      $("#convicted_at").datetimepicker({format:"YYYY-MM-DD"});
      
      $('[data-toggle="popover"]').popover();

    });
  </script>
    <script src="{{asset('Areas/Admin/Driver/Details/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Driver/Details/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Driver/Details/controller.js')}}"></script>

@endsection