@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection
@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      
      $('[data-toggle="popover"]').popover();

    });
  </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th colspan="2"><center><h3> Ticket {{$ticket->id}}</h3></center>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Car</td>
                            <td>{{$ticket->car->reg_no or null}}</td>
                        </tr>
                        <tr>
                            <td>Driver</td>
                            <td>{{$ticket->driver->name or null}}</td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th><h3 style="display: inline-block;">Uploaded Files</h3>
                            <a href="{{url('api/admin/cars/'.$ticket->car->id.'/tickets/'.$ticket->id.'/pdf')}}" class="btn btn-success pull-right"> Download the Pdf</a>  
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ticket->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img style="display: inline-block;"  class="img-responsive" src="{{$file->full_url}}" width="100"><a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                    <button type="button" class="btn btn-danger pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="{{url('admin/tickets/'.$file->id.'/delete')}}" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                </td>
                                @else
                                    <td>
                                        <p style="display: inline-block;">{{$file->name}}</p><a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                        <button type="button" class="btn btn-danger pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="{{url('admin/tickets/'.$file->id.'/delete')}}" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                    </td>
                                @endif
                            </tr> 
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
                <form enctype="multipart/form-data" method="POST" action="{{url('api/admin/cars/'.$ticket->car->id.'/tickets/'.$ticket->id.'/attachment')}}"> 
                    {!! csrf_field() !!}
                    <label class="custom-file">
                          <input type="file" id="file" name="file[]" multiple>
                    </label>
                    <input type="submit" name="submit" class="btn btn-primary" value="upload">
                </form>
            </div>
        </div>
    </div>
{{--     <div id="files">
        <div id="file-list">

        </div>
        <div id="file-add">
            <form method="POST" action="{{url('admin/tickets/'.$ticket->id.'/attach')}}">
                {!! csrf_field() !!}
                <input class="form-control" type="file" name="file">
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

    </div> --}}
@endsection