<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <title>Mercury</title>
    <base href="/chatlaravel/public/" target="_top">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.css")  }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("css/style.css") }}"/>
    <!-- <link href="{{ asset("css/font-awesome.css") }}" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset("css/fileinput.css") }}" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    @include('partials.nav')
    <div class="container mercuryContainer">
    @yield('content')
    </div>
  </body>
  <script src="{{ asset("js/jquery-1.11.3.min.js") }}"></script>
  <script src="{{ asset("js/bootstrap.min.js")}}"></script>
  <script src="{{ asset("js/angular.min.js") }}"></script>
  <script src="{{ asset("js/jquery-ui.min.js")}}"></script>
  <script src="{{ asset("js/fileinput.min.js")}}"></script>
  <script src="{{ asset("js/socket.io.js") }}"></script>
  <script src="{{ asset("js/mercury.js") }}"></script>
  @yield('scripts')
</html>