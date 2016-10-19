@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper">
        <h1>Manage Investors</h1>

        <div class="padded">
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Passport No.</th>
                    <th>DOB</th>
                    <th>Phone</th>
                    <th>Joined</th>

                </tr>
                @foreach($investorList as $investor)
                    <tr class="link-row">
                        <td>{{$investor->id}}</td>
                        <td><a href="{{url('/admin/investor/show/'.$investor->id)}}">{{$investor->email}}</a></td>

                        <td>{{$investor->name}}</td>
                        <td>{{$investor->passport_num}}</td>
                        <td>{{$investor->dob->toFormattedDateString()}}</td>
                        <td>{{$investor->phone}}</td>
                        <td>{{$investor->created_at->toFormattedDateString()}}</td>

                    </tr>
                @endforeach
            </table>

        </div>
    </div>
    <div class="fixed-footer-button-container">
        <div class="card-container">
            @include('partials.form.investor-create')
        </div>
        <div class="flex-container">
            <span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.fixed-footer-button').click(function () {
                $('.fixed-footer-button').toggleClass('clicked');
                $('.card-container').fadeToggle('fast');
                $('.extra-button').fadeToggle('fast');
            });
        });

    </script>
@endsection
