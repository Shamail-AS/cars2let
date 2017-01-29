@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">

@endsection
@section('scripts')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
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
      $("#pass_exp_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#pco_expires_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#licence_expires_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#driving_since").datetimepicker({format:"YYYY-MM-DD"});
      $('[data-toggle="popover"]').popover();

    });
  </script>

@endsection
@section("content")
	            <div class="container">    
	                <h2>Driver Files </h2>
	                <hr>
	                <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tbody>
                        @forelse($driver->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img style="display: inline-block;" class="img-responsive" src="{{$file->full_url}}" width="100">
                                    <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                     <button type="button" class="btn btn-danger pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="@if(!Auth::user()->isDriver){{url('admin/driver/'.$driver->id.'/file/'.$file->id)}} @else {{url('driver/files/'.$file->id.'/delete')}}@endif" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                </td>
                            </tr>
                                @else
                                    <td>
                                        <p style="display: inline-block;">{{$file->name}}</p>
                                        <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                        <button type="button" class="btn btn-danger  pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="@if(!Auth::user()->isDriver){{url('admin/driver/'.$driver->id.'/file/'.$file->id)}} @else{{url('driver/files/'.$file->id.'/delete')}}@endif" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                    </td>
                                @endif
                        @empty
                            <tr>
                                <td>
                                    no files
                                </td>
                            </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Upload Files</h3>
                        <form enctype="multipart/form-data" method="POST" action="@if(!Auth::user()->isDriver){{url('admin/driver/add/files/'.$driver->id)}} @else{{url('driver/files/')}}@endif"> 
                            {!! csrf_field() !!}
                            <label class="custom-file">
                                  <input type="file" id="file" name="file[]" multiple>
                            </label>
                            <input type="submit" name="submit" class="btn btn-primary" value="upload">
                        </form>
                    </div>
                </div>
            </div>

@endsection