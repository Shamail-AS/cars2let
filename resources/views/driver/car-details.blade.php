@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <br>
        <div class="list-group">
            <a class="list-group-item list-group-item-action active">
                <center><h4>Car Details</h4></center>
            </a>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered responsive">
                            <tbody>
                                <tr>
                                    <td>Model</td>
                                    <td>{{$car->model}}</td>
                                </tr>
                                <tr>
                                    <td>Year</td>
                                    <td>{{$car->year}}</td>
                                </tr>
                                <tr>
                                    <td>color</td>
                                    <td>{{$car->color}}</td>
                                </tr>
                                                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered responsive">
                            <tbody>
                                <tr>
                                    <td>Transmission</td>
                                    <td>{{$car->transmission}}</td>
                                </tr>
                                <tr>
                                    <td>pco_license</td>
                                    <td>{{$car->pco_licence}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th><h3 style="display: inline-block;">{{$car->reg_no}} Pictures</h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($car->files as $file)
                            <tr>
                                <td>
                                    <img style="display: inline-block;"  class="img-responsive" src="{{$file->full_url}}" width="100">
                                    <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                </td>
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