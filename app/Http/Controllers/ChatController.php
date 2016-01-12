<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller {
	private static $factory;

	public function __construct() {
		self::$factory = new WebserviceClient();
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

		return View('chats.main')->with('user', $user)
			->with('userChatList', $userChatResult["data"])
			->with('userBadge', $userBadgeResult["data"]);
	}

}