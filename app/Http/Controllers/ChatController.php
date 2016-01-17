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

	public function getChatListView() {
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

	public function getChatView($idGroup = null) {
		$user = Session::get('user');
		if (!is_null($idGroup)) {
			$groupChatResult = self::$factory->getGroupChat($user['ID_USER'], $idGroup);
			$messagesResult = $this->getChatMessage($user['ID_USER'], $groupChatResult[0]['ID_GROUP'], $groupChatResult[0]['IS_ADMIN']);

			//dd($messagesResult);

			return View('chats.chat')
				->with('user', $user)
				->with('chat', $groupChatResult[0])
				->with('messages', $messagesResult);
		}
		return redirect('chats');
	}

	public function getUserChatView($idUserChatWith = null) {
		$user = Session::get('user');
		if (!is_null($idUserChatWith)) {
			$userChatResult = self::$factory->getUserGroupChat($user['ID_USER'], $idUserChatWith);
			if (count($userChatResult) == 0) {
				$createGroupResult = self::$factory->createGroup(-1, -1, 3, $user['ID_USER'], $idUserChatWith);
				if ($createGroupResult == 1) {
					$userChatResult = self::$factory->getUserGroupChat($user['ID_USER'], $idUserChatWith);
					if (count($userChatResult) > 0) {
						$this->processAddMemberToGroup($userChatResult[0]["ID_GROUP"], $user['ID_USER']);
						$this->processAddMemberToGroup($userChatResult[0]["ID_GROUP"], $idUserChatWith);
					} else {
						Session::flash('alert-danger', 'Error occored, please contact administrator.[Can not create a chat]');
						return redirect('chats')->send();
					}
				} else {
					Session::flash('alert-danger', 'Error occored, please contact administrator.[Can not create a chat]');
					return redirect('chats')->send();
				}
			}

			$userChatWith = self::$factory->getUser($idUserChatWith);

			$messagesResult = $this->getChatMessage($user['ID_USER'], $userChatResult[0]['ID_GROUP'], $userChatResult[0]['IS_ADMIN']);

			//dd($messagesResult);
			return View('chats.chat')->with('user', $user)
				->with('userWith', $userChatWith)
				->with('chat', $userChatResult[0])
				->with('messages', $messagesResult);
		}
		return redirect('chats')->send();
	}

	private function getChatMessage($idUser, $idGroup, $groupType) {
		self::$factory->updateCurrentChat($idUser, $idGroup);
		self::$factory->addReadLogs($idUser, $idGroup);
		return $getChatMessagesResult = self::$factory->getChatMessages($idUser, $idGroup, $groupType);
	}

	private function processAddMemberToGroup($idGroup, $idUser) {
		$checkMemberInGroupChat = self::$factory->checkMemberInGroupChat($idGroup, $idUser);
		if ($checkMemberInGroupChat == 0) {
			$addmemberResult = self::$factory->addMemberToGroup($idGroup, $idUser);
			if ($addmemberResult != 1) {
				Session::flash('alert-danger', 'Error occored, please contact administrator.[Can not add member to group]');
				return redirect('chats')->send();
			}
		}
	}

}