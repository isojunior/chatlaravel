<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller {
	private static $factory;

	public function __construct() {
		if (!Session::has('user')) {
			return Redirect::to('/')->send();
		} else {
			self::$factory = new WebserviceClient();
		}
	}

	public function getChatView() {
		$user = Session::get('user');
		$userChatServiceName = "getGroupChatForAdmin";
		$userBadgeServiceName = "getUserBadge";
		if ($user['USER_TYPE'] == 0) {
			$userChatServiceName = "getGroupChatForUser";
			$userBadgeServiceName = "getUserBadge";
		}

		$userChatResult = self::$factory->callWebservice([
			'query' => [
				'service' => $userChatServiceName,
				'idUser' => $user['ID_USER'],
			],
		]);

		$userBadgeResult = self::$factory->callWebservice([
			'query' => [
				'service' => $userBadgeServiceName,
				'idUser' => $user['ID_USER'],
			],
		]);
		//dd($userChatResult);
		return View('chats.main')->with('user', $user)
			->with('userChatList', $userChatResult["data"])
			->with('userBadge', $userBadgeResult["data"]);
	}

}