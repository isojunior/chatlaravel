@extends('app')
@section('content')
    <div class="container-fluid" style="margin-top:60px">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
                    <div class="loginPanel loginPanelHeader panel-heading">Account</div>
                    <div class="panel-body">
                        @include('partials.flashmessage')
                            <div class="row">
                                <img class="avatar" src="img/avatar.png" alt="avatar" />
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ $user['FIRST_NAME'] }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ $user['LAST_NAME'] }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ $user['EMAIL'] }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ $user['TELEPHONE'] }}</label>
                                </div>
                            </div>
                            <a href="profile/edit">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection