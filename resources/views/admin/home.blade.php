@extends("layouts.app")

@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-container">
                   <div class="revenue-container">
                       <div class="revenue-breakdown">
                           <div class="breakdown-section">
                               <i class="fa fa-lg fa-user"></i>
                               <h1>Investors</h1>
                           </div>
                           <div class="breakdown-section">
                               <i class="fa fa-lg fa-car"></i>
                               <h1>Cars</h1>
                           </div>
                           <div class="breakdown-section">
                               <i class="fa fa-lg fa-user"></i>
                               <h1>Drivers</h1>
                           </div>
                           @if($user->isSuperAdmin)
                               <div class="breakdown-section">
                                   <i class="fa fa-lg fa-user"></i>
                                   <h1>Admin</h1>
                               </div>
                           @endif
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>




@endsection