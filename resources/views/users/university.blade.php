@extends('app')
@section('content')

    <div class="container-fluid" style="margin-top:60px">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
{{--                        {{print_r($university['data'][0])}}--}}
                        @foreach($university['data'] as $value)
                            {{$value['ID_UNIVERSITY']}}{{$value['NAME_THA']}}{{$value['NAME_ENG']}}  <br>
                            {{--{{ $i++ }}--}}
                        @endforeach
            </div>
        </div>
    </div>
    <a href="logout">Logout</a>
@endsection
@section('script')
@endsection