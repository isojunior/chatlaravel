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

	private function getAuthenSession() {
		$auth = Session::get('user');
		return $auth;
	}

	public function getChatView() {
		$user = $this->getAuthenSession();
		if ($user['USER_TYPE'] == 1) {
			$groupChatServiceName = "getAllAdminGroupChat";
			$userChatServiceName = "getAllUserGroupChat";
			$userBadgeServiceName = "getUserBadge";

		} else {
			$groupChatServiceName = "getAllGroupChat";
			$userChatServiceName = "getAllUserGroupChat";
			$userBadgeServiceName = "getUserBadge";
		}
		$groupChatResult = $this->getChatListByService($groupChatServiceName);

		$userChatResult = $this->getChatListByService($userChatServiceName);

		$userBadgeResult = $this->getChatListByService($userBadgeServiceName);

		return View('chats.main')->with('user', $user)
			->with('groupChatList', $groupChatResult["data"])
			->with('userChatList', $userChatResult["data"])
			->with('userBadge', $userBadgeResult["data"]);
	}

	private function getChatListByService($service) {
		$user = $this->getAuthenSession();
		return self::$factory->callWebservice([
			'query' => [
				'service' => $service,
				'idUser' => $user['ID_USER'],
			],
		]);
	}
}