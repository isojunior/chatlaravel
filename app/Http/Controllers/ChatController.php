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
		$groupChatServiceName = "getAllAdminGroupChat";
		$userChatServiceName = "getAllUserGroupChat";
		$userBadgeServiceName = "getUserBadge";
		if ($user['USER_TYPE'] == 0) {
			$groupChatServiceName = "getAllGroupChat";
			$userChatServiceName = "getAllUserGroupChat";
			$userBadgeServiceName = "getUserBadge";
		}

		$groupChatResult = self::$factory->callWebservice([
			'query' => [
				'service' => $groupChatServiceName,
				'idUser' => $user['ID_USER'],
				'idUniversity' => $user['ID_UNIVERSITY'],
				'idFaculty' => $user['ID_FACULTY'],
			],
		]);

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
			->with('groupChatList', $groupChatResult["data"])
			->with('userChatList', $userChatResult["data"])
			->with('userBadge', $userBadgeResult["data"]);
	}

}