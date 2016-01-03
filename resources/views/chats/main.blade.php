@extends('app')
@section('content')
<br><br><br>
    @if( Session::get('user')['AUTHORIZE_BY'] =='1')
        APPROVE
    @else
        This Application only specified for eduction with advice and useful for students <br>
        therefore wait admin institution's approved
    @endif

<a href="profile">Link Profile</a>
    <a href="logout">Logout</a>
@endsection