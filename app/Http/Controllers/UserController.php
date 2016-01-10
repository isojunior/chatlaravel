<?php

namespace App\Http\Controllers;

use App\Http\Constrants;
use App\Http\Controllers\Controller;
use App\Http\Utils;
use App\Http\WebserviceClient;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
	private static $factory;

	public function __construct() {
		self::$factory = new WebserviceClient();
	}

	private function getUserLogin($email, $password) {
		$query = DB::table('MERCURY_USER')
			->where('EMAIL', '=', $email)
			->where('PASSWORD', '=', $password)
			->first();
		return $query;
	}

	private function checkMobile($mobile) {
		$query = Db::table('MERCURY_USER')
			->where('TELEPHONE', '=', $mobile)
			->count();
		return $query;
	}

	private function checkEmail($email) {
		$query = Db::table('MERCURY_USER')
			->where('EMAIL', '=', $email)
			->count();
		return $query;
	}

	private function checkMobileEdit($mobile, $id) {
		$query = Db::table('MERCURY_USER')
			->where('TELEPHONE', '=', $mobile)
			->where('ID_USER', '<>', $id)
			->count();
		return $query;
	}

	private function checkEmailEdit($email, $id) {
		$query = Db::table('MERCURY_USER')
			->where('EMAIL', '=', $email)
			->where('ID_USER', '<>', $id)
			->count();
		return $query;
	}
	public function getFaculty() {
//		$webServiceClient = self::$factory->getWebServiceClient();
		$faculty = self::$factory->callWebservice([
			'query' => [
				'service' => 'getAllFaculty',
				'idUniversity' => '9027',
			],
		]);
		dd($faculty);
		//dd(json_decode($response->getBody()->getContents(), true));
	}
	public function processUniversityAndFaculty() {
		$university = self::$factory->callWebservice([
			'query' => [
				'service' => 'getAllUniversity',
			],
		]);
		$item = array();
		$item[0] = [0, '------SELECT UNIVERSITY------'];
		foreach ($university['data'] as $data) {
			$item[$data['ID_UNIVERSITY']] = [$data['ID_UNIVERSITY'], $data['NAME_THA']];
		}
		return view('users.registerUniversity')->with('university', $university)->with('items', $item);
	}

	public function editProfileView() {
		$auth = Session::get('user');
		return view('users.editProfile')->with('profile', $auth);
	}

	public function getProfileView() {
		$auth = Session::get('user');
		return view('users.profile')->with('user', $auth);
	}

	public function getRegisterView() {
		return view('users.register');
	}

	public function getLoginView() {
		$auth = Session::get('user');
		if (isset($auth)) {
			return redirect('chats');
		} else {
			return view('users.login');
		}
	}

	public function processLogout() {
		Session::forget('user');
		return redirect('/');
	}

	public function processLogin(Request $request) {
		$rules = [
			'email' => 'required',
			'password' => 'required',
		];

		$messages = [
			'email.required' => 'Email is required',
			'password.required' => 'Password is required',
		];

		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect('/')->withErrors($validator)->withInput();
		} else {
			$email = $request->input('email');
			$password = $request->input('password');

			$loginResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'login',
					'email' => Utils::encodeParameter($email),
					'password' => Utils::encodeParameter($password),
				],
			]);

			if (count($loginResult["data"]) == 1) {
				$user = $loginResult["data"][0];
				Session::put('user', $user);
				return redirect('chats');
			} else {
				Session::flash('alert-danger', 'Email or Password is incorrect.');
				return redirect('/');
			}
		}
	}

	public function uploadProfileImage(Request $request) {
		$auth = Session::get('user');
		$rules = [
			'profileImage' => 'image|max:1024',
		];
		$messages = [
			'profileImage.image' => 'A file is not images, Plese specific image file.',
			'profileImage.max' => 'Image size must be less then or equal 1MB',
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			return redirect('profile')->withErrors($validator)->withInput();
		} else {
			$profileImage = Input::file('profileImage');
			if ($profileImage != null && $profileImage->isValid()) {
				$destinationPath = Constrants::PROFILE_PATH;
				$extension = $profileImage->getClientOriginalExtension();
				$fileNameFull = $auth["ID_USER"] . "." . $extension;
				$fileMoved = $profileImage->move($destinationPath, $fileNameFull);
				dd($fileMoved->getRealPath());
				if (File::exists($fileMoved->getRealPath())) {
					Session::flash('alert-success', 'Upload image success.');
					return redirect('profile');
				} else {
					Session::flash('alert-danger', 'Error occored 2, please contact administrator.');
					return redirect('profile');
				}
			} else {
				Session::flash('alert-danger', 'Error occored 1, please contact administrator.');
				return redirect('profile');
			}
		}
	}

	public function processEditProfile(Request $request) {
		$auth = Session::get('user');
		$rules = array(
			'Name' => 'required|max:100',
			'Surname' => 'required|max:100',
			'Position' => 'required|max:100',
			'Mobile' => 'required|max:100',
			'Email' => 'required|email|max:100',
		);
		$message = [
			'Name.required' => 'Name is Required',
			'Name.max' => 'Name length must me less then or equals 100 character.',
			'Surname.required' => 'SurName is Required',
			'Surname.max' => 'SurName length must me less then or equals 100 character.',
			'Position.required' => 'Position is Required',
			'Position.max' => 'Position length must me less then or equals 100 character.',
			'Mobile.required' => 'Mobile is Required',
			'Mobile.max' => 'Mobile length must me less then or equals 100 character.',
			'Email.required' => 'Email is Required',
			'Email.email' => 'Email format not correct',
			'Email.max' => 'Email length must me less then or equals 100 character.',
		];
		$validator = Validator::make($request->all(), $rules, $message);
		if ($validator->fails()) {
			return redirect('profile/edit')->withErrors($validator)->withInput();
		} else {
			$name = $request->input('Name');
			$surName = $request->input('Surname');
			$position = $request->input('Position');
			$mobile = $request->input('Mobile');
			$email = $request->input('Email');

			$isExistTelephoneResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'userTelephoneExist',
					'idUser' => $auth['ID_USER'],
					'telephone' => Utils::encodeParameter($mobile),
				],
			]);
			if ($isExistTelephoneResult["data"][0]["result"] == 1) {
				Session::flash('alert-danger', 'Mobile already to use');
				return redirect('profile/edit')->withinput();
			}

			$isExistEmailResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'userEmailExist',
					'idUser' => $auth['ID_USER'],
					'telephone' => Utils::encodeParameter($email),
				],
			]);

			if ($isExistEmailResult["data"][0]["result"] == 1) {
				Session::flash('alert-danger', 'Email already to use');
				return redirect('profile/edit')->withInput();
			}

			$updateResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'updateUser',
					'idUser' => $auth["ID_USER"],
					'firstName' => Utils::encodeParameter($name),
					'lastName' => Utils::encodeParameter($surName),
					'telephone' => Utils::encodeParameter($mobile),
					'email' => Utils::encodeParameter($email),
					'position' => Utils::encodeParameter($position),
				],
			]);
			if ($updateResult["data"][0]["result"] == 1) {
				$userResult = self::$factory->callWebservice([
					'query' => [
						'service' => 'getUser',
						'idUser' => $auth['ID_USER'],
					],
				]);
				Session::put('user', $userResult["data"][0]);

				Session::flash('alert-success', 'Update Successful');
				return redirect('profile');
			} else {
				Session::flash('alert-danger', 'An error occored, please contact admin.');
				return redirect('profile/edit')->withInput();
			}

		}
	}

	public function processRegister(Request $request) {
		$rules = array(
			'Name' => 'required|max:100',
			'Surname' => 'required|max:100',
			'Position' => 'required|max:100',
			'Mobile' => 'required|max:100',
			'Email' => 'required|email|max:100',
			'Password' => 'required|confirmed|max:100',
			'Password_confirmation' => 'required',
		);
		$message = [
			'Name.required' => 'Name is Required.',
			'Name.max' => 'Name length must me less then or equals 100 character.',
			'Surname.required' => 'SurName is Required.',
			'Surname.max' => 'SurName length must me less then or equals 100 character.',
			'Position.required' => 'Position is Required.',
			'Position.max' => 'Position length must me less then or equals 100 character.',
			'Mobile.required' => 'Mobile is Required.',
			'Mobile.max' => 'Mobile length must me less then or equals 100 character.',
			'Email.required' => 'Email is Required.',
			'Email.email' => 'Email format not correct.',
			'Email.max' => 'Email length must me less then or equals 100 character.',
			'Password.required' => 'Password is Required.',
			'Password.confirmed' => 'Password not match.',
			'Password_confirmation.required' => 'Password Confirm is Required.',
			'Password.max' => 'Password length must me less then or equals 100 character.',
		];
		$validator = Validator::make($request->all(), $rules, $message);
		if ($validator->fails()) {
			return redirect('register')->withErrors($validator)->withInput();
		} else {
			$name = $request->input('Name');
			$surName = $request->input('Surname');
			$position = $request->input('Position');
			$mobile = $request->input('Mobile');
			$email = $request->input('Email');
			$password = $request->input('Password');

			$isExistTelephoneResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'isExistTelephone',
					'telephone' => Utils::encodeParameter($mobile),
				],
			]);

			if ($isExistTelephoneResult["data"][0]["result"] == 1) {
				Session::flash('alert-danger', 'Mobile already to use');
				return redirect('register')->withinput();
			}

			$isExistEmailResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'isExistEmail',
					'telephone' => Utils::encodeParameter($email),
				],
			]);

			if ($isExistEmailResult["data"][0]["result"] == 1) {
				Session::flash('alert-danger', 'Email already to use');
				return redirect('register')->withInput();
			}

			$registerResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'addUser',
					'firstName' => Utils::encodeParameter($name),
					'lastName' => Utils::encodeParameter($surName),
					'telephone' => Utils::encodeParameter($mobile),
					'email' => Utils::encodeParameter($email),
					'position' => Utils::encodeParameter($position),
					'password' => Utils::encodeParameter($password),
				],
			]);

			Session::flash('alert-success', 'Register Successful');
			return redirect('/');
		}
	}

	public function updateUniAndFac(Request $request) {
		$auth = Session::get('user');
		$inputUni = $request->input("university");
		$inputFac = $request->input("faculty");
		$updateFac = self::$factory->callWebservice([
			'query' => [
				'service' => 'updateFaculty',
				'idUniversity' => $inputUni,
				'idFaculty' => $inputFac,
				'idUser' => $auth['ID_USER'],
			],
		]);
		if ($updateFac["data"][0]["result"] == 1) {
			$userResult = self::$factory->callWebservice([
				'query' => [
					'service' => 'getUser',
					'idUser' => $auth['ID_USER'],
				],
			]);
			Session::put('user', $userResult["data"][0]);
			Session::flash('alert-success', 'Update Successful');
		}
		return redirect('profile');
	}
}
