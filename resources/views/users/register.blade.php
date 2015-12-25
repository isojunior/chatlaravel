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
                                                        <div class="form-group @if ($errors->has('regis_name')) has-error @endif">
                                                                <label class="col-sm-4 control-label">ชื่อ</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regis_name" maxlength="20" placeholder="ชื่อ" value="{{ old('regis_name') }}">
                                                                        @if($errors->has('regis_name')) <p class="help-block">{{$errors->first('regis_name')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_surname')) has-error @endif">
                                                                <label class="col-sm-4 control-label">นามสกุล</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regis_surname" maxlength="20" placeholder="นามสกุล" value="{{ old('regis_surname') }}">
                                                                        @if($errors->has('regis_surname')) <p class="help-block">{{$errors->first('regis_surname')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_position')) has-error @endif">
                                                                <label class="col-sm-4 control-label">ตำแหน่ง</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regis_position" maxlength="20" placeholder="ตำแหน่ง" value="{{ old('regis_position') }}">
                                                                        @if($errors->has('regis_position')) <p class="help-block">{{$errors->first('regis_position')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_mobile')) has-error @endif">
                                                                <label class="col-sm-4 control-label">หมายเลขโทรศัพท์มือถือ</label>
                                                                <div class="col-sm-5">
                                                                        <input type="text" class="form-control" name="regis_mobile" onkeypress="validate(event)" maxlength="15" placeholder="หมายเลขโทรศัพท์มือถือ" value="{{ old('regis_mobile') }}">
                                                                        @if($errors->has('regis_mobile')) <p class="help-block">{{$errors->first('regis_mobile')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_email')) has-error @endif">
                                                                <label class="col-sm-4 control-label">อีเมล์</label>
                                                                <div class="col-sm-5">
                                                                        <input type="email" class="form-control" name="regis_email" maxlength="20" placeholder="อีเมล์" value="{{ old('regis_email') }}">
                                                                        @if($errors->has('regis_email')) <p class="help-block">{{$errors->first('regis_email')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_password')) has-error @endif">
                                                                <label class="col-sm-4 control-label">รหัสผ่าน</label>
                                                                <div class="col-sm-5">
                                                                        <input type="password" class="form-control" name="regis_password" maxlength="20" placeholder="รหัสผ่าน" value="{{ old('regis_password') }}">
                                                                        @if($errors->has('regis_password')) <p class="help-block">{{$errors->first('regis_password')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group @if ($errors->has('regis_password_confirmation')) has-error @endif">
                                                                <label class="col-sm-4 control-label">ยืนยันรหัสผ่าน</label>
                                                                <div class="col-sm-5">
                                                                        <input type="password" class="form-control" name="regis_password_confirmation" maxlength="20" placeholder="ยืนยันรหัสผ่าน" value="{{ old('regis_password_confirmation') }}">
                                                                        @if($errors->has('regis_password_confirmation')) <p class="help-block">{{$errors->first('regis_password_confirmation')}}</p>@endif
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="col-sm-5 col-sm-offset-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                                ลงทะเบียน
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