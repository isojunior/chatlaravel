<nav class="navbar navbar-custom  navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Mercury</a>
        </div>

        @if(Session::has('user'))
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ \App\Http\Utils::setActive('chats') }}"><a href="chats"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
                <li class="{{ \App\Http\Utils::setActive('contacts') }}"><a href="contact"><span class="glyphicon glyphicon-user"></span> Contacts</a></li>
                <li class="{{ \App\Http\Utils::setActive('profile') }}"><a href="profile"><span class="glyphicon glyphicon-home"></span> Account</a></li>
            </ul>
        </div>
        @endif
    </div>
</nav>