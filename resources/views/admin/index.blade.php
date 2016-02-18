@extends('layouts.app')

@section('content')
    <h1>Manage Admins</h1>
    @if(Auth::user()->isSuperAdmin)
        <h1>Welcome!</h1>
    @else
        <h1>Not Permitted</h1>
    @endif

@endsection