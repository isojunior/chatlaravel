<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\WebserviceClient;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller {
	private static $factory;

	public function __construct() {
		self::$factory = new WebserviceClient();
	}

	public function exampleIndex() {
		$university = self::$factory->callWebservice([
			'query' => [
				'service' => 'getAllUniversity',
			],
		]);
		$rowsUniversity = array();
		foreach ($university as $rowProvince) {
			$rowsUniversity[$rowProvince->ID_UNIVERSITY] = $rowsUniversity->NAME_THA;
		}
		return view('users.registerUniversity')->with('university', $rowsUniversity);
	}

	public function getFaculty() {
		$input = Input::get('option');

		$faculty = self::$factory->callWebservice([
			'query' => [
				'service' => 'getAllFaculty',
				'idUniversity' => $input,
			],
		]);

		$item = array();
		$item[0] = [0, 'ส่วนกลาง CENTER'];
		foreach ($faculty['data'] as $data) {
			$item[$data['ID_FACULTY']] = [$data['ID_FACULTY'], $data['NAME_THA'] . ' ' . $data['NAME_ENG']];
		}

		return Response::make($item);
	}
}
