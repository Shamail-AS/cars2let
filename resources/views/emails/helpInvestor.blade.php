@extends('app')

@section('content')
    <h1>An Investor needs help</h1>
    <table>
        <tbody>
        <tr>
            <td>Investor</td>
            <td><a href="{{url('/admin/investor/show/'.$investor->id)}}"></a>{{$investor->name}}</td>
        </tr>
        <tr>
            <td>Message</td>
            <td>{{$question}}</td>
        </tr>
        </tbody>
    </table>
    <p>The investor has been CC'd on this email, you may communicate directly</p>
@endsection