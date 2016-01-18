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
}
?>