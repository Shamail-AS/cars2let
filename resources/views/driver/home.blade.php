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
                       <a href="{{url('driver/cars')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-car"></i>
                           <h1>Cars List</h1>
                       </a>
                       <a href="{{url('driver/files')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-file"></i>
                           <h1>Files</h1>
                       </a>
                       <a href="{{url('driver/edit')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-info"></i>
                           <h1>Edit Info</h1>
                       </a>
                    </div>
                    <div class="flex-admin-areas">
                       <a href="{{url('driver/approvedContracts')}}" class="admin-box nostyle">
                           <i class="fa fa-5x fa-user"></i>
                           <h1>Approved Contracts</h1>
                       </a>
                   </div>
                </div>
            </div>
        </div>
    </div>




@endsection