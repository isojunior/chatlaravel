<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use App\Constrants;
use App\Http\WebServiceClient;
use App\Http\Utils;

class UserController extends Controller
{
    private static $factory;

    public function __construct() {
        self::$factory = new WebserviceClient();
    }

    private function getAuthenSession(){
        $session = Session::get('user');
        if(!isset($session)){
            $this->processLogout();
        }
        return $session;
    }

    private function getUserLogin($email,$password){
        $query = DB::table('MERCURY_USER')
            ->where('EMAIL','=',$email)
            ->where('PASSWORD','=',$password)
            ->first();
        return $query;
    }

    private function checkMobile($mobile){
        $query = Db::table('MERCURY_USER')
            ->where('TELEPHONE','=',$mobile)
            ->count();
        return $query;
    }

    private function checkEmail($email){
        $query = Db::table('MERCURY_USER')
            ->where('EMAIL','=',$email)
            ->count();
        return $query;
    }

    private function checkMobileEdit($mobile,$id){
        $query = Db::table('MERCURY_USER')
            ->where('TELEPHONE','=',$mobile)
            ->where('ID_USER','<>',$id)
            ->count();
        return $query;
    }

    private function checkEmailEdit($email,$id){
        $query = Db::table('MERCURY_USER')
            ->where('EMAIL','=',$email)
            ->where('ID_USER','<>',$id)
            ->count();
        return $query;
    }
    public function getFaculty(){
        $webServiceClient = self::$factory->getWebServiceClient();
        //currently use same uri with base uri bcuz webservice no specify pathURI
        $response = $webServiceClient->get(Constrants::WEB_SERVICE_URI, [
            'query' => [
                'service' => 'getAllFaculty',
                'idUniversity'=>'9027'
            ]
        ]);
        dd( json_decode($response->getBody()->getContents(),true));
    }
    public function testJTGService(){
        $response = self::$factory->callWebservice([
                'query' => [
                'service' => 'getAllUniversity'
            ]
        ]);
        $university =  json_decode($response->getBody()->getContents(),true);
        return view('users.university')->with('university',$university);
    }

    public function editProfileView()
    {
        $session = $this->getAuthenSession();
        $profile = Db::table('MERCURY_USER')
            ->where('ID_USER','=',$session['ID_USER'])
            ->get();
        return view('users.editProfile')->with('profile',$profile);
    }

    public function getProfileView()
    {
        $session = $this->getAuthenSession();
        $profile = Db::table('MERCURY_USER')->where('ID_USER','=',$session['ID_USER'])
            ->get();
        return view('users.profile')->with('profile',$profile);
    }

    public function getRegisterView()
    {
        return view('users.register');
    }

    public function getLoginView()
    {
        return view('users.login');
    }

    public function processLogout()
    {
        Session::forget('user');
        return redirect('/');
    }

    public function processLogin(Request $request)
    {
        $rules=[
            'email' =>'required',
            'password'=>'required',
        ];
        
        $messages = [
            'email.required'=>'Email is required',
            'password.required'=>'Password is required'
        ];

        $validator =  Validator::make($request->all(),$rules,$messages);
        if($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }else{
            $email = $request->input('email');
            $password = $request->input('password');

            $auth = DB::table('MERCURY_USER')->where('EMAIL', '=', $email)
                        ->where('PASSWORD', '=', $password)
                        ->first();
            $response = self::$factory->callWebservice([
                'query' => [
                    'service' => 'login',
                    'email' => Utils::encodeParameter($email),
                    'password' => Utils::encodeParameter($password)
                ]
            ]);

            $loginResult =  json_decode($response->getBody()->getContents(),true);
            //dd($loginResult);

            if(count($loginResult["data"])==1){
                Session::put('user',$loginResult["data"][0]);
                return redirect('chats');
            }
            else{
                Session::flash('alert-danger', 'Email or Password is incorrect.');
                return redirect('/');
            }
        }
    }

    public function processEditProfile(Request $request)
    {
        $session = $this->getAuthenSession();
        $rules = array(
            'Name' =>'required|max:100',
            'Surname' =>'required|max:100',
            'Position' =>'required|max:100',
            'Mobile'=>'required|max:100',
            'Email'=>'required|email|max:100'
        );
        $message = [
            'Name.required'=>'Name is Required',
            'Name.max'=>'Name length must me less then or equals 100 character.',
            'Surname.required'=>'SurName is Required',
            'Surname.max'=>'SurName length must me less then or equals 100 character.',
            'Position.required'=>'Position is Required',
            'Position.max'=>'Position length must me less then or equals 100 character.',
            'Mobile.required'=>'Mobile is Required',
            'Mobile.max'=>'Mobile length must me less then or equals 100 character.',
            'Email.required'=>'Email is Required',
            'Email.email'=>'Email format not correct',
            'Email.max'=>'Email length must me less then or equals 100 character.'
        ];
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails()){
            return redirect('profile/'.$id)->withErrors($validator)->withInput();
        }else{
            $Name = $request->input('Name');
            $SurName = $request->input('Surname');
            $Position = $request->input('Position');
            $Mobile = $request->input('Mobile');
            $Email = $request->input('Email');

            $checkMobile = $this->checkMobileEdit($Mobile,$session['ID_USER']);
            if($checkMobile>0){
                Session::flash('alert-danger', 'Mobile already to use');
                return redirect('register')->withinput();
            }
            $checkEmail = $this->checkEmailEdit($Email,$session['ID_USER']);
            if($checkEmail>0){
                Session::flash('alert-danger', 'Email already to use');
                return redirect('register')->withInput();
            }

            Db::table('mercury_user')->where('ID_USER','=',$session['ID_USER'])
                ->update(
                [
                    'FIRST_NAME'=>$Name,
                    'LAST_NAME'=>$SurName,
                    'TELEPHONE'=>$Mobile,
                    'EMAIL'=>$Email,
                    'POSITION'=>$Position
                ]
            );
            Session::flash('alert-success', 'Update Successful');
            return redirect('profile');
        }
    }

    public function processRegister(Request $request)
    {
        $rules = array(
            'Name' =>'required|max:100',
            'Surname' =>'required|max:100',
            'Position' =>'required|max:100',
            'Mobile'=>'required|max:100',
            'Email'=>'required|email|max:100',
            'Password'=>'required|confirmed|max:100',
            'Password_confirmation'=>'required'
        );
        $message = [
            'Name.required'=>'Name is Required.',
            'Name.max'=>'Name length must me less then or equals 100 character.',
            'Surname.required'=>'SurName is Required.',
            'Surname.max'=>'SurName length must me less then or equals 100 character.',
            'Position.required'=>'Position is Required.',
            'Position.max'=>'Position length must me less then or equals 100 character.',
            'Mobile.required'=>'Mobile is Required.',
            'Mobile.max'=>'Mobile length must me less then or equals 100 character.',
            'Email.required'=>'Email is Required.',
            'Email.email'=>'Email format not correct.',
            'Email.max'=>'Email length must me less then or equals 100 character.',
            'Password.required'=>'Password is Required.',
            'Password.confirmed'=>'Password not match.',
            'Password_confirmation.required'=>'Password Confirm is Required.',
            'Password.max'=>'Password length must me less then or equals 100 character.'
        ];
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails()){
            return redirect('register')->withErrors($validator)->withInput();
        }else{
            $Name = $request->input('Name');
            $SurName = $request->input('Surname');
            $Position = $request->input('Position');
            $Mobile = $request->input('Mobile');
            $Email = $request->input('Email');
            $Pass = $request->input('Password');

            $checkMobile = $this->checkMobile($Mobile);
            if($checkMobile>0){
                Session::flash('alert-danger', 'Mobile already to use');
                return redirect('register')->withinput();
            }
            $checkEmail = $this->checkEmail($Email);
            if($checkEmail>0){
                Session::flash('alert-danger', 'Email already to use');
                return redirect('register')->withInput();
            }

            Db::table('mercury_user')->insert(
                [
                    'FIRST_NAME'=>$Name,
                    'LAST_NAME'=>$SurName,
                    'TELEPHONE'=>$Mobile,
                    'EMAIL'=>$Email,
                    'PASSWORD'=>$Pass,
                    'POSITION'=>$Position
                ]
            );
            Session::flash('alert-success', 'Register Successful');
            return redirect('register');
        }
    }
}
