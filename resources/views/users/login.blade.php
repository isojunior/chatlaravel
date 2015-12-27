@extends('app')
@section('content')
<div class="container-fluid" style="margin-top:60px">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            @include('partials.flashmessage')
            <div class="panel panel-primary loginPanel">
                <div class="loginPanel loginPanelHeader panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="login">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" maxlength="20" value="{{ old('email') }}">
                                @if($errors->has('email')) <p class="help-block">{{$errors->first('email')}}</p>@endif
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="password" maxlength="20">
                                @if($errors->has('password')) <p class="help-block">{{$errors->first('password')}}</p>@endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary btnKhcycle">
                                Sign in
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-4">
                                <a href="register">Register</a>
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
@endsection