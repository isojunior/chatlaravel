@extends('app')
@section('content')
<div class="container-fluid" >
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="panel panel-info loginPanel">
                <div class="loginPanel loginPanelHeader panel-heading">Account</div>
                <div class="panel-body">
                    @include('partials.flashmessage')
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="javascript:uploadImage()"><img class="img-responsive img-circle avatar userImageProfile" src="http://apps.jobtopgun.com/Mercury/photos/{{$user['ID_USER']}}.jpg" onerror='this.src="img/avatar.png"'></a>
                        </div>
                    </div>
                    <div id="uploadImage" class="row uploadImageInput">
                        <div class="col-xs-8 col-xs-offset-2">
                            <input id="uploadImageInput" type="file" class="file" data-preview-file-type="text" data-show-preview="false" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="text-center fontBold">{{ $user['FIRST_NAME'] }} {{ $user['LAST_NAME'] }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="text-center">{{ $user['EMAIL'] }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="text-center">Tel. {{ $user['TELEPHONE'] }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a class="btn btn-primary" href="profile/edit">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#uploadImageInput").fileinput();
    });

    function uploadImage(){
         $("#uploadImage").slideDown(300);
    }
</script>
@endsection