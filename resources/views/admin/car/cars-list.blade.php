@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4">
                    <div class="thumbnail">
                        @forelse($car->files as $file)
                        <img src="{{$file->full_url}}" class="img-responsive">
                            <?php break; ?>
                        @empty
                        <img src="{{asset('img/no-img.png')}}" class="img-responsive">
                        @endforelse
                        <div class="caption">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="">{{$car->reg_no}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right">£{{$car->price}}/week</h4> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                @if($car->status == 'off-rent')
                                <img src="{{asset('img/greendot.jpg')}}" width="10" height="10">
                                &nbsp; &nbsp; Available
                                @else 
                                    <img src="{{asset('img/reddot.jpg')}}" width="10" height="10">
                                    &nbsp; &nbsp; Unavailable
                                @endif
                                </div>
                            </div>
                            <hr>
                            <ul>
                                <li> Make: {{$car->make}}</li>
                                <li> Year: {{$car->year}}</li>
                                <li> Model: {{$car->model}}</li>
                                <li> Color: {{$car->colour}}</li>
                                <li> Transmission:{{$car->transmission}}</li>
                            </ul>
                            <p><a href="{{url('drivers/new/?car_reg_no='.$car->reg_no)}}" class="btn btn-success btn-xs" role="button">Book Now</a></p>    
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
<!--/container -->
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