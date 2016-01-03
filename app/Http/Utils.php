<?php
namespace App\Http;
class Utils 
{
	public static function setActive($route){
        return (\Request::is($route.'/*') 
        	|| \Request::is($route) 
        	||(\Request::is('/')&&$route=="chats")) ? "active" : '';
    }
}

?>