@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
            <div class="panel panel-primary loginPanel">
                <div class="loginPanel loginPanelHeader panel-heading">University and Faculty</div>
                <div id="setupPanelBody" class="panel-body">
                <form id="setupSubmit" action="setupUniversity" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('partials.flashmessage')
                    <div class="form-group hideWhenLoad">
                        <label>University</label>
                        <select id="make" name="university" class="form-control">
                            @foreach($universities as $university)
                                <option value="{{$university[0]}}"
                                        {{Session::get('user')['ID_UNIVERSITY'] == $university[0] ? 'selected':''}}>
                                    {{$university[1]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group hideWhenLoad">
                        <label>Faculty</label>
                        <select id="model" name="faculty" class="form-control">
                            @if(Session::get('user')['ID_FACULTY']==-1)
                                <option>-- กรุณาเลือกมหาวิทยาลัย --</option>
                            @else
                                @foreach($faculties as $faculty)
                                <option value="{{$faculty[0]}}"
                                        {{Session::get('user')['ID_FACULTY'] == $faculty[0] ? 'selected':''}}>
                                    {{$faculty[1]}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group hideWhenLoad">
                        <input type="submit" value="Save" class="btn btn-info btn-block">
                    </div>
                    <img src='img/preload_horizontal.gif' class='img-responsive center-block showWhenLoad'/>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function($){
            $("#setupSubmit").submit(function(event){
                $(".hideWhenLoad").hide();
                $(".showWhenLoad").css('display', 'block');
            });

            $('#make').change(function(){
                if($('#make').val()>0){
                    $.get("{{ url('api/getFaculty')}}",
                        { option: $(this).val() },
                        function(data) {
                            var model = $('#model');
                            model.empty();
                            $.each(data, function(index, element) {
                                model.append("<option value='"+ element[0] +"'>" + element[1] + "</option>");
                            });
                    });
                }
                else{
                    $('#model').empty().append("<option>-- กรุณาเลือกมหาวิทยาลัย --</option>");
                }
            });
        });
    </script>
@endsection