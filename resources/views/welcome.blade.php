<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.css")  }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset("css/style.css") }}"/>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-custom  navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}
                    {{--<span class="sr-only">Toggle navigation</span>--}}
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                {{--</button>--}}
                <a class="navbar-brand" href="#">Project name</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">

            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary loginPanel">
                    <div class="loginPanel loginPanelHeader panel-heading">เข้าสู่ระบบสมาชิก</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group @if ($errors->has('kh_username')) has-error @endif">
                                <label class="col-sm-4 control-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="kh_username" maxlength="20" value="{{ old('kh_username') }}">
                                    @if($errors->has('kh_username')) <p class="help-block">{{$errors->first('kh_username')}}</p>@endif
                                </div>

                            </div>

                            <div class="form-group @if ($errors->has('kh_password')) has-error @endif">
                                <label class="col-sm-4 control-label">Password</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="kh_password" maxlength="20">
                                    @if($errors->has('kh_password')) <p class="help-block">{{$errors->first('kh_password')}}</p>@endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary btnKhcycle">
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-4">
                                    <a href="register">ลงทะเบียน</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
<script href="{{asset("js/bootstrap.js")}}"></script>
</html>
