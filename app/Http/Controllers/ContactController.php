<?php

namespace App\Http\Controllers;

use App\Http\Constrants;
use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller {
	private static $factory;

	public function __construct() {
		self::$factory = new WebserviceClient();
	}

	// get Authorzied & Unauthorized list
	private function getAuthorizedList($services, $university, $faculty, $result = array()) {
		foreach ($services as $s) {
			array_push($result,
				self::$factory->callWebservice([
					'query' => [
						'service' => $s,
						'idUniversity' => $university,
						'idFaculty' => $faculty,
					],
				])
			);
		}
		return $result;
	}

	private function getContactList($service, $result = array()) {
		foreach ($service as $s) {
			array_push($result,
				self::$factory->callWebservice([
					'query' => [
						'service' => $s,
					],
				])
			);
		}
		return $result;
	}

	public function getContactView() {
		$user = Session::get('user');
		if ($user['USER_TYPE'] == 1) {
			$services = array("getAllMemberUniversityAndFaculty", "getAllAdmin");
			$contacts = $this->getContactList($services);

			return View('contacts.main')
				->with('user', $user)
				->with('groupList', $contacts[0]['data'])
				->with('adminList', $contacts[1]['data']);

		} else {
			if ($user['AUTHORIZE'] == 3) {
				$memberAuthorizedResult = self::$factory->callWebservice([
					'query' => [
						'service' => "getMemberAuthorized",
						'idUniversity' => $user['ID_UNIVERSITY'],
						'idFaculty' => $user['ID_FACULTY'],
					],
				]);

				return View('contacts.main')
					->with('user', $user)
					->with('memberAuthorizedList', $memberAuthorizedResult);
			} else {
				$unAuthorizeResult = null;
				$allAdminResult = null;
				$groupResult = null;
				$memberResult = null;
				$memberRejectedResult = null;
				if ($user['AUTHORIZE'] == 1) {
					$unAuthorizeResult = self::$factory->callWebservice([
						'query' => [
							'service' => "getMemberUnAuthorized",
							'idUniversity' => $user['ID_UNIVERSITY'],
							'idFaculty' => $user['ID_FACULTY'],
						],
					]);

					$memberRejectedResult = self::$factory->callWebservice([
						'query' => [
							'service' => "getMemberReject",
							'idUniversity' => $user['ID_UNIVERSITY'],
							'idFaculty' => $user['ID_FACULTY'],
						],
					]);

				}
				/** todo case group **/

				$allAdminResult = self::$factory->callWebservice([
					'query' => [
						'service' => "getAllAdmin",
						'idUniversity' => $user['ID_UNIVERSITY'],
					],
				]);

				$memberResult = self::$factory->callWebservice([
					'query' => [
						'service' => "getMember",
						'idUniversity' => $user['ID_UNIVERSITY'],
						'idFaculty' => $user['ID_FACULTY'],
					],
				]);

				return View('contacts.main')
					->with('unAuthorizeList', $unAuthorizeResult['data'])
					->with('adminList', $allAdminResult['data'])
					->with('memberList', $memberResult['data'])
					->with('rejectList', $memberRejectedResult['data'])
					->with('user', $user);
			}
		}
	}

	public function getAuthorizedResult($idUniversityRequest = null, $idFacultyRequest = null) {
		$idUniversity = $idUniversityRequest == null ? $_GET['data'][0] : $idUniversityRequest;
		$idFaculty = $idFacultyRequest == null ? $_GET['data'][1] : $idFacultyRequest;
		$services = array("getMemberUnAuthorized", "getMemberAuthorized", "getMemberGroup", "getMemberReject");
		$authorizedList = $this->getAuthorizedList($services, $idUniversity, $idFaculty);

		return View('contacts.authorizeResultTemplate')
			->with('unAuthorize', $authorizedList[0]['data'])
			->with('highUser', $authorizedList[1]['data'])
			->with('normalUser', $authorizedList[2]['data'])
			->with('rejectUser', $authorizedList[3]['data']);
	}

	public function processAuthorizeUser($authorizeStatus = null, $idUser = null) {
		$admin = Session::get('user');
		if ($admin['USER_TYPE'] == 1
			&& null != $authorizeStatus
			&& ($authorizeStatus >= 0 && $authorizeStatus <= 3)) {
			$userResult = $this->getUser($idUser);
			if (null != $userResult) {
				$userIdUniversity = $userResult[0]['ID_UNIVERSITY'];
				$userIdFaculty = $userResult[0]['ID_FACULTY'];
				$authorizeResult = $this->authorizeUser($idUser, $authorizeStatus, $admin['ID_USER']);
				if ($authorizeResult == 1) {
					if ($authorizeStatus == 1 || $authorizeStatus == 2) {
						$this->addUserToAdminGroup($idUser, $userIdUniversity, $userIdFaculty);
						$this->addUserToPrimaryGroup($idUser, $userIdUniversity, $userIdFaculty);
						$this->sendPushResult($idUser, Constrants::AUTHORIZE);
					} else if ($authorizeStatus == 3) {
						$this->removeUserFromAdminGroup($idUser, $userIdUniversity, $userIdFaculty);
						$this->removeUserFromPrimaryGroup($idUser, $userIdUniversity, $userIdFaculty);
					}
					return $this->getAuthorizedResult($userIdUniversity, $userIdFaculty);
				} else {
					Session::flash('alert-danger', 'Error occored, please contact administrator.[Error update authorize code]');
					return "error1";
				}

			} else {
				Session::flash('alert-danger', 'Error occored, please contact administrator.[Not found user]');
				return "error2";
			}
		} else {
			Session::flash('alert-danger', 'Error occored, please contact administrator.[Error occored when accessing the process.]');
			return "error3";
		}
	}

	private function removeUserFromAdminGroup($idUser, $idUniversity, $idFaculty) {
		$adminGroupChatResult = $this->getAdminGroupChat($idUniversity, $idFaculty, $idUser);
		if ($adminGroupChatResult == null) {
			$idGroup = $adminGroupChatResult[0]["ID_GROUP"];
			$checkMemberInGroupChat = $this->checkMemberInGroupChat($idGroup, $idUser);
			if ($checkMemberInGroupChat == 1) {
				$this->removeMemberFromGroup($idGroup, $idUser);
			}
		}
	}

	private function removeUserFromPrimaryGroup($idUser, $idUniversity, $idFaculty) {
		$primaryGroupChatResult = $this->getPrimaryGroupChat($idUniversity, $idFaculty, $idUser);
		if ($primaryGroupChatResult == null) {
			$idGroup = $adminGroupChatResult[0]["ID_GROUP"];
			$primaryGroupChatResult = $this->checkMemberInGroupChat($idGroup, $idUser);
			if ($primaryGroupChatResult == 1) {
				$this->removeMemberFromGroup($idGroup, $idUser);
			}
		}
	}

	private function addUserToPrimaryGroup($idUser, $idUniversity, $idFaculty) {
		$primaryGroupChatResult = $this->getPrimaryGroupChat($idUniversity, $idFaculty, $idUser);
		if ($primaryGroupChatResult == null) {
			//create group then get again
			$createGroupResult = $this->createGroup($idUniversity, $idFaculty, $idUser, 1, -1, -1);
			if ($createGroupResult == 1) {
				$primaryGroupChatResult = $this->getPrimaryGroupChat($idUniversity, $idFaculty, $idUser);
				if ($primaryGroupChatResult == null) {
					Session::flash('alert-danger', 'Error occored, please contact administrator.[Error occored when create group]');
					return "error4";
				}
			} else {
				Session::flash('alert-danger', 'Error occored, please contact administrator.[Error occored when create group]');
				return "error5";
			}
		}
		$this->processAddMemberToGroup($primaryGroupChatResult[0]["ID_GROUP"], $idUser);
	}

	private function addUserToAdminGroup($idUser, $idUniversity, $idFaculty) {
		$adminGroupChatResult = $this->getAdminGroupChat($idUniversity, $idFaculty, $idUser);
		if ($adminGroupChatResult == null) {
			//create group then get again
			$createGroupResult = $this->createGroup($idUniversity, $idFaculty, $idUser, 1, -1, -1);
			if ($createGroupResult == 1) {
				$adminGroupChatResult = $this->getAdminGroupChat($idUniversity, $idFaculty, $idUser);
				if ($adminGroupChatResult == null) {
					Session::flash('alert-danger', 'Error occored, please contact administrator.[Error occored when create group]');
					return "error6";
				}
			} else {
				Session::flash('alert-danger', 'Error occored, please contact administrator.[Error occored when create group]');
				return "error7";
			}
		}
		$this->processAddMemberToGroup($adminGroupChatResult[0]["ID_GROUP"], $idUser);
	}

	private function processAddMemberToGroup($idGroup, $idUser) {
		$checkMemberInGroupChat = $this->checkMemberInGroupChat($idGroup, $idUser);
		if ($checkMemberInGroupChat == 0) {
			$addmemberResult = $this->addMemberToGroup($idGroup, $idUser);
			if ($addmemberResult != 1) {
				Session::flash('alert-danger', 'Error occored, please contact administrator.[Can not add member to group]');
				return "error8";
			}
		} else {
			Session::flash('alert-danger', 'Error occored, please contact administrator.[User already exist in group]');
			return "error8";
		}
	}

	private function removeMemberFromGroup($idGroup, $idUser) {
		$addMemberToGroupResult = self::$factory->callWebservice([
			'query' => [
				'service' => "removeMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $addMemberToGroupResult['data'][0]['result'];
	}

	private function sendPushResult($idUser, $action) {
		$addMemberToGroupResult = self::$factory->callWebservice([
			'query' => [
				'service' => "sendPushResult",
				'idUser' => $idUser,
				'action' => $action,
			],
		]);
		return $addMemberToGroupResult['data'][0]['result'];
	}

	private function addMemberToGroup($idGroup, $idUser) {
		$addMemberToGroupResult = self::$factory->callWebservice([
			'query' => [
				'service' => "addMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $addMemberToGroupResult['data'][0]['result'];
	}

	private function checkMemberInGroupChat($idGroup, $idUser) {
		$checkMemberInGroupChatResult = self::$factory->callWebservice([
			'query' => [
				'service' => "isMemberGroupChat",
				'idGroup' => $idGroup,
				'idUser' => $idUser,
			],
		]);
		return $checkMemberInGroupChatResult['data'][0]['result'];
	}

	private function createGroup($idUniversity, $idFaculty, $isAdmin, $idUser1, $idUser2) {
		$createGroupResult = self::$factory->callWebservice([
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

	private function getUser($idUser) {
		$userResult = self::$factory->callWebservice([
			'query' => [
				'service' => "getUser",
				'idUser' => $idUser,
			],
		]);
		return $userResult['data'];
	}

	private function getPrimaryGroupChat($idUniversity, $idFaculty, $idUser) {
		$primaryGroupChatResult = self::$factory->callWebservice([
			'query' => [
				'service' => "getPrimaryGroupChat",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
				'idUser' => $idUser,
			],
		]);
		return $primaryGroupChatResult['data'];
	}

	private function getAdminGroupChat($idUniversity, $idFaculty, $idUser) {
		$adminGroupChatResult = self::$factory->callWebservice([
			'query' => [
				'service' => "getAdminGroupChat",
				'idUniversity' => $idUniversity,
				'idFaculty' => $idFaculty,
				'idUser' => $idUser,
			],
		]);
		return $adminGroupChatResult['data'];
	}

	private function authorizeUser($idUser, $authorizeStatus, $authorizeBy) {
		$authorizeResult = self::$factory->callWebservice([
			'query' => [
				'service' => "updateAuthorization",
				'idUser' => $idUser,
				'authorize' => $authorizeStatus,
				'authorizeBy' => $authorizeBy,
			],
		]);
		return $authorizeResult['data'][0]['result'];
	}
}
