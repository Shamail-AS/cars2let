@extends("layouts.app")

@section("styles")
    <link rel="stylesheet" href="{{asset('css/admin/admin.css')}}">
@endsection

@section("content")

    <div class="wrapper">
        <h1>{{Auth::user()->isSuperAdmin ? "Super ":""}}Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="flex-container">
                   <div class="flex-admin-areas">
                       <a href="{{url('admin/investor/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Investors</h1>
                       </a>
                       <a href="{{url('admin/car/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-car"></i>
                           <h1>Cars</h1>
                       </a>
                       <a href="{{url('admin/driver/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Drivers</h1>
                       </a>
                    </div>
                    <div class="flex-admin-areas">
                       <a href="{{url('admin/unapproved/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Unapproved Drivers</h1>
                       </a>
                       <a href="{{url('admin/insurance/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Insurance Policies</h1>
                       </a>
                       <a href="{{url('admin/supplier/all')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Suppliers</h1>
                       </a>
                       @if(Auth::user()->isSuperAdmin)
                           <a href="{{url('super/admin/all')}}" class="admin-box nostyle">
                               <i class="fa fa-5x fa-user"></i>
                              <h1>Users</h1>
                           </a>
                       @endif
                   </div>
                </div>
            </div>
        </div>
    </div>




@endsection