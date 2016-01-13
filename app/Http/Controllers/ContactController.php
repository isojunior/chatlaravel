<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

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
	
	public function getAuthorizedResult(){
	
		$idUniversity = $_GET['data'][0];
		$idFaculty = $_GET['data'][1];
		$services = array("getMemberUnAuthorized","getMemberAuthorized","getMemberGroup","getMemberReject");
		$authorizedList = $this->getAuthorizedList($services, $idUniversity, $idFaculty);
		
		return View('contacts.authorizeResultTemplate')
					->with('unAuthorize', 	$authorizedList[0]['data'])
					->with('highUser', 		$authorizedList[1]['data'])
					->with('normalUser', 	$authorizedList[2]['data'])
					->with('rejectUser',		$authorizedList[3]['data']);
	}
}
