@extends('app')
@section('content')

    <div class="container-fluid" style="margin-top:60px">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
                    <div class="loginPanel loginPanelHeader panel-heading">Edit Profile</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                Errors. Please Check this<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        {{--<li>{{ $error }}</li>--}}
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @include('partials.flashmessage')
                        <form class="form-horizontal" role="form" method="post" action="editProfile">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group @if ($errors->has('Name')) has-error @endif">
                                <label class="col-sm-4 control-label">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="Name" maxlength="20" placeholder="Name" value="{{ old('Name') }}">
                                    @if($errors->has('Name')) <p class="help-block">{{$errors->first('Name')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('Surname')) has-error @endif">
                                <label class="col-sm-4 control-label">SureName</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="Surname" maxlength="20" placeholder="SureName" value="{{ old('Surname') }}">
                                    @if($errors->has('Surname')) <p class="help-block">{{$errors->first('Surname')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('Mobile')) has-error @endif">
                                <label class="col-sm-4 control-label">MobilePhone</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="Mobile" onkeypress="validate(event)" maxlength="15" placeholder="MobilePhone" value="{{ old('Mobile') }}">
                                    @if($errors->has('Mobile')) <p class="help-block">{{$errors->first('Mobile')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('Email')) has-error @endif">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" name="Email" maxlength="20" placeholder="Email" value="{{ old('Email') }}">
                                    @if($errors->has('Email')) <p class="help-block">{{$errors->first('Email')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('Position')) has-error @endif">
                                <label class="col-sm-4 control-label">Position</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="Position" maxlength="20" placeholder="Position" value="{{ old('Position') }}">
                                    @if($errors->has('Position')) <p class="help-block">{{$errors->first('Position')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
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
@section('script')
@endsection