<?php
namespace App\Http;
use GuzzleHttp\Client;

class WebServiceClient {
	private static $client;

	public function getWebServiceClient() {
		if (self::$client == null) {
			self::$client = new Client([
				'base_uri' => Constrants::WEB_SERVICE_URI,
				'timeout' => 60.0,
			]);
		}
		return self::$client;
	}

	public function callWebservice($param) {
		$webServiceClient = $this->getWebServiceClient();
		$response = $webServiceClient->get(Constrants::WEB_SERVICE_URI, $param);
		return json_decode($response->getBody()->getContents(), true);
	}

	public function updateCurrentChat($idUser, $idGroup) {
		$updateCurrentChatResult = $this->callWebservice([
			'query' => [
				'service' => "updateCurrentChat",
				'idUser' => $idUser,
				'idGroup' => $idGroup,
			],
		]);
		return $updateCurrentChatResult['data'][0]['result'];
	}

	public function addReadLogs($idUser, $idGroup) {
		$addReadLogsResult = $this->callWebservice([
			'query' => [
				'service' => "updateCurrentChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $addReadLogsResult['data'][0]['result'];
	}

	public function getChatMessages($idUser, $idGroup, $groupType) {
		$getMessages = $this->callWebservice([
			'query' => [
				'service' => "getAllChatMessage",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
				'isAdmin' => $groupType,
			],
		]);
		return $getMessages['data'];
	}

	public function getUser($idUser) {
		$userResult = $this->callWebservice([
			'query' => [
				'service' => "getUser",
				'idUser' => $idUser,
			],
		]);
		return $userResult['data'];
	}

	public function getUserGroupChat($idUser, $idUserChatWith) {
		$getUserChat = $this->callWebservice([
			'query' => [
				'service' => "getUserGroupChat",
				'idUser1' => $idUser,
				'idUser2' => $idUserChatWith,
			],
		]);
		return $getUserChat['data'];
	}

	public function getGroupChat($idUser, $idGroup) {
		$getGroupChat = $this->callWebservice([
			'query' => [
				'service' => "getGroupChat",
				'idUser' => $idUser,
				'idGroup' => $idGroup,
			],
		]);
		return $getGroupChat['data'];
	}

	public function createGroup($idUniversity, $idFaculty, $isAdmin, $idUser1, $idUser2) {
		$createGroupResult = $this->callWebservice([
			'query' => [
				'service' => "addGroupChat",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
				'isAdmin' => $isAdmin,
				'idUser1' => $idUser1,
				'idUser2' => $idUser2,
			],
		]);
		return $createGroupResult['data'][0]['result'];
	}

	public function checkMemberInGroupChat($idGroup, $idUser) {
		$checkMemberInGroupChatResult = $this->callWebservice([
			'query' => [
				'service' => "isMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $checkMemberInGroupChatResult['data'][0]['result'];
	}

	public function addMemberToGroup($idGroup, $idUser) {
		$addMemberToGroupResult = $this->callWebservice([
			'query' => [
				'service' => "addMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $addMemberToGroupResult['data'][0]['result'];
	}

	public function getMemberAuthorized($idUniversity, $idFaculty) {
		$memberAuthorizedResult = $this->callWebservice([
			'query' => [
				'service' => "getMemberAuthorized",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
			],
		]);
		return $memberAuthorizedResult['data'];
	}

	public function removeMemberFromGroup($idGroup, $idUser) {
		$addMemberToGroupResult = $this->callWebservice([
			'query' => [
				'service' => "removeMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $addMemberToGroupResult['data'][0]['result'];
	}

	public function getPrimaryGroupChat($idUniversity, $idFaculty, $idUser) {
		$primaryGroupChatResult = $this->callWebservice([
			'query' => [
				'service' => "getPrimaryGroupChat",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
				'idUser' => $idUser,
			],
		]);
		return $primaryGroupChatResult['data'];
	}

	public function getAdminGroupChat($idUniversity, $idFaculty, $idUser) {
		$adminGroupChatResult = $this->callWebservice([
			'query' => [
				'service' => "getAdminGroupChat",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
				'idUser' => $idUser,
			],
		]);
		return $adminGroupChatResult['data'];
	}

	public function authorizeUser($idUser, $authorizeStatus, $authorizeBy) {
		$authorizeResult = $this->callWebservice([
			'query' => [
				'service' => "updateAuthorization",
				'idUser' => $idUser,
				'authorize' => $authorizeStatus,
				'authorizeBy' => $authorizeBy,
			],
		]);
		return $authorizeResult['data'][0]['result'];
	}

	public function sendPushResult($idUser, $action) {
		$sendPushResult = $this->callWebservice([
			'query' => [
				'service' => "sendPushResult",
				'idUser' => $idUser,
				'action' => $action,
			],
		]);
		return $sendPushResult['data'][0]['result'];
	}
	public function requestAccepted($idUser, $idUniversity, $idFacalty) {
		$sendnotification = $this->callWebservice([
			'query' => [
				'service' => 'requestAccepted',
				'idUser' => $idUser,
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFacalty,
			],
		]);
		return $sendnotification['data'][0]['result'];
	}

	public function addChatMessage($idUser, $idGroup, $chatType, $idSticker, $idStickerGroup,
		$message) {
		$addChatMessageResult = $this->callWebservice([
			'query' => [
				'service' => "addChatMessage",
				'idUser' => $idUser,
				'idGroup' => $idGroup,
				'chatType' => $chatType,
				'idStickerGroup' => $idStickerGroup,
				'idSticker' => $idSticker,
				'message' => $message,
			],
		]);
		return $addChatMessageResult['data'];
	}
	
	public function getMember ($idUniversity, $idFaculty) {
		$memberResult = $this->callWebservice([
			'query' => [
				'service' => "getMember",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
			],
		]);
		return $memberResult['data'];
	}
	
	public function getAllAdmin ($idUniversity, $idFaculty) {
		$adminResult = $this->callWebservice([
			'query' => [
				'service' => "getAllAdmin",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
			],
		]);
		return $adminResult['data'];
	}
}
?>