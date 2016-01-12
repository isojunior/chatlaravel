<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use App\Http\Constrants;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
	private static $factory;

	public function __construct() {
		if (!Session::has('user')) {
			return Redirect::to('/')->send();
		} else {
			self::$factory = new WebserviceClient();
		}
	}
	
	private function getContactList($services, Array $result = array()) {
		foreach ($services as $s) {
			array_push($result, 
					self::$factory->callWebservice([
						'query' => [
							'service' => $s
						],
					])
			);
		}
		return $result;
	}
	
	// get Authorzied & Unauthorized list
	private function getAuthorizedList($services, $university, $faculty, Array $result = array()) {
		foreach ($services as $s) {
			array_push($result, 
					self::$factory->callWebservice([
						'query' => [
							'service' => $s,
							'idUniversity' => $university,
							'idFaculty' => $faculty
						],
					])
			);
		}
		return $result;
	}
	
	public function getContactView() {		
		$user = Session::get('user');
		if($user['USER_TYPE'] == 1) {
			$services = array("getAllMemberUniversityAndFaculty","getAllAdmin");
			$contacts = $this->getContactList($services);
		
		return View('contacts.list')
			->with('user', $user)
			->with('groupList', $contacts[0]['data'])
			->with('adminList', $contacts[1]['data'])
			->with('company', Constrants::TOPGUN_COMPANY_NAME);
		
		} else {
			return View('contacts.list')->with('user', $user);
		}
	}
	
	public function getAuthorizedResult(){
		$idUniversity = $_GET['data'][0];
		$idFaculty = $_GET['data'][1];
		$services = array("getMemberAuthorized","getMemberUnAuthorized","getMemberGroup","getMemberReject");
		$authorized_list = $this->getAuthorizedList($services, $idUniversity, $idFaculty);
		dd($authorized_list);
		//return Response::make($authorized_list);
	}

}
