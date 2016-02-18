@extends("layouts.app")

@section("styles")
 <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-container">
                   <div class="flex-admin-areas">
                       <a href="{{url('admin/investor')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Investors</h1>
                       </a>
                       <a href="{{url('admin/car')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-car"></i>
                           <h1>Cars</h1>
                       </a>
                       <a href="{{url('admin/driver')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Drivers</h1>
                       </a>
                       @if(Auth::user()->isSuperAdmin)
                           <a href="{{url('admin/list')}}" class="admin-box nostyle">
                               <i class="fa fa-5x fa-user"></i>
                               <h1>Admins</h1>
                           </a>
                       @endif
                   </div>
                </div>
            </div>
        </div>
    </div>




@endsection