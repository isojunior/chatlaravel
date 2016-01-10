<?php

namespace App\Http\Controllers;

use App\Http\Constrants;
use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller {
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
		if (!isset($auth)) {
			$this->processLogout();
		}
		return $auth;
	}

	private function getContactList($service, Array $result = array()) {
		$user = $this->getAuthenSession();
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
		$user = $this->getAuthenSession();
		if ($user['USER_TYPE'] == 1) {
			$service_set = array("getAllMemberUniversityAndFaculty", "getAllAdmin");
		}
		$contacts = $this->getContactList($service_set);

		return View('contacts.list')
			->with('user', $user)
			->with('groupList', $contacts[0])
			->with('adminList', $contacts[1])
			->with('company', Constrants::TOPGUN_COMPANY_NAME);
	}

}
