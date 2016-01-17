<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LRedis;

class SocketController extends Controller {
	public function index() {
		return view('socket');
	}

	public function writeMessage() {
		return view('writemessage');
	}

	public function sendMessage(Request $request) {
		$redis = LRedis::connection();
		$redis->publish('message', $request->input('message'));
		return redirect('writeMessage');
	}
	public function systemMessage()
	{
		$redis = LRedis::connection();
		$redis->publish('chat-message', json_encode([
			'msg' =>'System Message',
			'nickname'=>'System',
			'system' => true
		]));
		return '1';
	}
}
