{{--<nav class="navbar navbar-custom  navbar-fixed-top">--}}
  {{--<div class="container">--}}
    {{--<div class="navbar-header">--}}
        {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}
            {{--<span class="sr-only">Toggle navigation</span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
        {{--</button>--}}
        {{--<a class="navbar-brand" href="#">Mercury</a>--}}
    {{--</div>--}}
    {{--<div id="navbar" class="collapse navbar-collapse">--}}

    {{--</div><!--/.nav-collapse -->--}}
  {{--</div>--}}
{{--</nav>--}}


<nav class="navbar navbar-custom  navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Mercury</a>
        </div>

        @if(Session::has('user'))
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="chats"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Contacts</a></li>
                <li><a href="profile"><span class="glyphicon glyphicon-home"></span> Account</a></li>
            </ul>
        </div>
        @endif


    </div>
</nav>