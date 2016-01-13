<?php

namespace App\Http\Controllers;

use App\Http\Constrants;
use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller {
	private static $factory;

	public function __construct() {
		if (!Session::has('user')) {
			return Redirect::to('/')->send();
		} else {
			self::$factory = new WebserviceClient();
		}
	}
	
	// get Authorzied & Unauthorized list
	private function getAuthorizedList($services, $university, $faculty, $result = array()) {
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
	
	public function getAuthorizedDetail($params, $result = array()) {
		$membeTypeIndex = 0;
		$innerIndex = 0;
		foreach($params as $key){
			foreach($key as $value){
				$result[$membeTypeIndex][$innerIndex] = $value;
				$innerIndex++;
			}
			$membeTypeIndex++;
		}
		return $result;
	}
	
	public function getAuthorizedResult(){
	
		$idUniversity = $_GET['data'][0];
		$idFaculty = $_GET['data'][1];
		$services = array("getMemberUnAuthorized","getMemberAuthorized","getMemberGroup","getMemberReject");
		$authorizedList = $this->getAuthorizedList($services, $idUniversity, $idFaculty);
		$authorizedArrangedList = array($authorizedList[0]['data'],$authorizedList[1]['data'],$authorizedList[2]['data'],$authorizedList[3]['data']);
		$result = $this->getAuthorizedDetail($authorizedArrangedList);

		dd($result);
		//dd(key($result));
		//return json_encode($result);
		//return Response::make($authorized_list);
		//return Response::make('authorizedMember', $authorized_list[0]['data']);
	}
}
