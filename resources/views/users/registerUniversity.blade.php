@extends('app')
@section('content')

    <div class="container-fluid" style="margin-top:60px">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">

                    <p id="project-description"></p>
{{--                        {{print_r($university['data'][0])}}--}}
                        @foreach($university['data'] as $value)
                            {{--{{$value['ID_UNIVERSITY']}}{{$value['NAME_THA']}}{{$value['NAME_ENG']}}  <br>--}}
                            {{--{{ $i++ }}--}}
                        @endforeach
            </div>
        </div>
    </div>
    <a href="logout">Logout</a>
        <div id="project-label">Select a project (type "j" for a start):</div>
        {{--<img id="project-icon" src="images/transparent_1x1.png" class="ui-state-default" alt="">--}}
        <input id="project">
        <input type="hidden" id="project-id">
        <p id="project-description"></p>

    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
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
                            $( "#project-icon" ).attr( "src", "images/" + ui.item.icon );

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