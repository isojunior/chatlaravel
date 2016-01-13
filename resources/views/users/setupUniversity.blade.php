@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
                    <div class="loginPanel loginPanelHeader panel-heading">University and Faculty</div>
                    <div class="panel-body">
                    <form action="registerUniFac" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>University</label>
                            <select id="make" name="university" class="form-control">
                                @foreach($items as $data)
                                    <option value="{{$data[0]}}"
                                            {{Session::get('user')['ID_UNIVERSITY'] == $data[0] ? 'selected':''}}>
                                        {{$data[1]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Faculty</label>
                            <select id="model" name="faculty" class="form-control">
                                @if(Session::get('user')['ID_FACULTY']==-1)
                                    <option>Please choose University make first</option>
                                @else
                                    <option value="{{$user['FACULTY'][0]['ID_FACULTY']}}">{{$user['FACULTY'][0]['NAME_THA']}} {{$user['FACULTY'][0]['NAME_ENG']}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-info btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $(document).ready(function($){
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
    </script>
@endsection