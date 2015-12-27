@extends('app')
@section('content')
        <div class="container-fluid" style="margin-top:60px">
                <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                <div class="panel panel-primary loginPanel">
                                        <div class="loginPanel loginPanelHeader panel-heading">ลงทะเบียน</div>
                                        <div class="panel-body">
                                                @if (count($errors) > 0)
                                                        <div class="alert alert-danger">
                                                                เกิดข้อผิดพลาด กรุณาตรวจสอบ.<br><br>
                                                                <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                                {{--<li>{{ $error }}</li>--}}
                                                                        @endforeach
                                                                </ul>
                                                        </div>
                                                @endif

                                                @include('partials.flashmessage')
                                                <form class="form-horizontal" role="form" method="post" action="register">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="form-group @if ($errors->has('regisName')) has-error @endif">
                                                                <label class="col-sm-4 control-label">Name</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regisName" maxlength="20" placeholder="Name" value="{{ old('regisName') }}">
                                                                        @if($errors->has('regisName')) <p class="help-block">{{$errors->first('regisName')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisSurname')) has-error @endif">
                                                                <label class="col-sm-4 control-label">SureName</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regisSurname" maxlength="20" placeholder="SureName" value="{{ old('regisSurname') }}">
                                                                        @if($errors->has('regisSurname')) <p class="help-block">{{$errors->first('regisSurname')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisPosition')) has-error @endif">
                                                                <label class="col-sm-4 control-label">Position</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regisPosition" maxlength="20" placeholder="Position" value="{{ old('regisPosition') }}">
                                                                        @if($errors->has('regisPosition')) <p class="help-block">{{$errors->first('regisPosition')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisMobile')) has-error @endif">
                                                                <label class="col-sm-4 control-label">MobilePhone</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regisMobile" onkeypress="validate(event)" maxlength="15" placeholder="MobilePhone" value="{{ old('regisMobile') }}">
                                                                        @if($errors->has('regisMobile')) <p class="help-block">{{$errors->first('regisMobile')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisEmail')) has-error @endif">
                                                                <label class="col-sm-4 control-label">Email</label>
                                                                <div class="col-sm-5">
                                                                        <input type="email" class="form-control" name="regisEmail" maxlength="20" placeholder="Email" value="{{ old('regisEmail') }}">
                                                                        @if($errors->has('regisEmail')) <p class="help-block">{{$errors->first('regisEmail')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisPassword')) has-error @endif">
                                                                <label class="col-sm-4 control-label">Password</label>
                                                                <div class="col-sm-5">
                                                                        <input type="password" class="form-control" name="regisPassword" maxlength="20" placeholder="Password" value="{{ old('regisPassword') }}">
                                                                        @if($errors->has('regisPassword')) <p class="help-block">{{$errors->first('regisPassword')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regisPassword_confirmation')) has-error @endif">
                                                                <label class="col-sm-4 control-label">Confirm Password</label>
                                                                <div class="col-sm-5">
                                                                        <input type="password" class="form-control" name="regisPassword_confirmation" maxlength="20" placeholder="Confirm Password" value="{{ old('regisPassword_confirmation') }}">
                                                                        @if($errors->has('regisPassword_confirmation')) <p class="help-block">{{$errors->first('regisPassword_confirmation')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="col-sm-5 col-sm-offset-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                                Register
                                                                        </button>
                                                                </div>
                                                        </div>

                                                </form>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
@endsection
@section('scripts')
        <script>
                function validate(evt) {
                        var theEvent = evt || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode( key );
                        var regex = /[0-9]|\./;
                        if( !regex.test(key) ) {
                                theEvent.returnValue = false;
                                if(theEvent.preventDefault) theEvent.preventDefault();
                        }
                }
        </script>
@endsection