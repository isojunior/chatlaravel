<?php
namespace App\Http;
class Utils 
{
	public static function setActive($route){
        return (\Request::is($route.'/*') 
        	|| \Request::is($route) 
        	||(\Request::is('/')&&$route=="chats")) ? "active" : '';
    }

    public static function encodeParameter($e){
    	return base64_encode(urlencode($e));
    }

    public static function decodeParameter($d){
    	return urlencode(base64_encode($d));
    }
}

?>