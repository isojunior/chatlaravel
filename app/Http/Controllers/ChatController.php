<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ChatController extends Controller
{

	public function __construct()
	{
		if(!Session::has('user'))
		{
			return Redirect::to('/')->send();
		}
	}

	public function getChatView()
	{
		return View('chats.main');
	}
}