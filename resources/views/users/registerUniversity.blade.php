@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
                    <div class="loginPanel loginPanelHeader panel-heading">University and Faculty</div>
                    <p id="project-description"></p>
                    {{--{{print_r($university['data'][0])}}--}}
                        @foreach($university['data'] as $value)
                            {{--{{$value['ID_UNIVERSITY']}}{{$value['NAME_THA']}}{{$value['NAME_ENG']}}  <br>--}}
                            {{--{{ $i++ }}--}}
                        @endforeach
                    <form action="registerUniFac" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>University</label>
                            <select id="make" name="university" class="form-control">
                                @foreach($items as $data)
                                    {{--        print {{$data}};--}}
                                    <option value="{{$data[0]}}">{{$data[1]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Faculty</label>
                            <select id="model" name="faculty" class="form-control">
                                <option>Please choose University make first</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-info btn-block">
                        </div>
                        <br>
                    </form>
            </div>
        </div>
    </div>
    {{--<a href="logout">Logout</a>--}}
        {{--<div id="project-label">Select a project (type "j" for a start):</div>--}}
        {{--<img id="project-icon" src="images/transparent_1x1.png" class="ui-state-default" alt="">--}}
        {{--<input id="project">--}}
        {{--<input type="hidden" id="project-id">--}}
        {{--<p id="project-description"></p>--}}
    {{--</div>--}}
{{--<br><br><br><br><br><br><br><br><br>--}}
    {{--<h1>Dropdown demo</h1>--}}
    {{--<form>--}}
        {{--<select id="make" name="make">--}}
            {{--@foreach($items as $data)--}}
                {{--        print {{$data}};--}}
                {{--<option value="{{$data[0]}}">{{$data[0].'--'.$data[1]}}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
        {{--<br>--}}
        {{--<select id="model" name="model">--}}
            {{--<option>Please choose University make first</option>--}}
        {{--</select>--}}
    {{--</form>--}}


@endsection
@section('scripts')
    <script>

        jQuery(document).ready(function($){
            $('#make').change(function(){
                $.get("{{ url('api/getFaculty')}}",
                        { option: $(this).val() },
                        function(data) {
                            var model = $('#model');
                            model.empty();

                            $.each(data, function(index, element) {
                                model.append("<option value='"+ element[0] +"'>" + element[1] + "</option>");
                            });
                        });
            });
        });

        $(function() {

            //--console.log({{--$university['data']}});--}}
            //--console.log(<--?php// echo $university['data'] ?>);--}}
            //--var data = {{-- json_encode($university['data'])}}--}}
            //            console.log('123');
            var projects = [
                {
                    value: "jquery",
                    label: "jQuery",
                    desc: "the write less, do more, JavaScript library",
                    icon: "jquery_32x32.png"
                },
                {
                    value: "jquery-ui",
                    label: "jQuery UI",
                    desc: "the official user interface library for jQuery",
                    icon: "jqueryui_32x32.png"
                },
                {
                    value: "sizzlejs",
                    label: "Sizzle JS",
                    desc: "a pure-JavaScript CSS selector engine",
                    icon: "sizzlejs_32x32.png"
                }
            ];

            $( "#project" ).autocomplete({
                        minLength: 0,
                        source: projects,
                        focus: function( event, ui ) {
                            $( "#project" ).val( ui.item.label );
                            return false;
                        },
                        select: function( event, ui ) {
                            $( "#project" ).val( ui.item.label );
                            $( "#project-id" ).val( ui.item.value );
                            $( "#project-description" ).html( ui.item.desc );
//                            $( "#project-icon" ).attr( "src", "images/" + ui.item.icon );

                            return false;
                        }
                    })
                    .autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                        .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                        .appendTo( ul );
            };
        });
    </script>

@endsection