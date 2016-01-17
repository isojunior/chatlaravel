<?php
namespace App\Http;
class Utils {
	public static function setActive($route) {
		return (\Request::is($route . '/*')
			|| \Request::is($route)
			|| (\Request::is('/') && $route == "chats")) ? "active" : '';
	}

	public static function encodeParameter($e) {
		return base64_encode(urlencode($e));
	}

	public static function decodeParameter($d) {
		return urlencode(base64_encode($d));
	}

	public static function unicode_decode($str) {
		return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
			return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		}, $str);
	}
}

?>