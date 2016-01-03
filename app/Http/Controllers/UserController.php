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
use GuzzleHttp\Client;

class UserController extends Controller
{
    const WEB_SERVICE_URI = "http://apps.jobtopgun.com/Mercury/1.3/iServ.php";
    private $client; 

    private function getWebServiceClient(){
        if($this->client==null){
            $this->client = new Client([
                'base_uri' => self::WEB_SERVICE_URI,
                'timeout'  => 2.0,
            ]);
        }
        return $this->client;
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
        $webServiceClient = $this->getWebServiceClient();
        $response = $webServiceClient->get(self::WEB_SERVICE_URI, [
            'query' => [
                'service' => 'getAllFaculty',
                'idUniversity'=>'9027'
            ]
        ]);
        dd( json_decode($response->getBody()->getContents(),true));
    }
    public function testJTGService(){
        $webServiceClient = $this->getWebServiceClient();
        $response = $webServiceClient->get(self::WEB_SERVICE_URI, [
            'query' => [
                'service' => 'getAllUniversity'
            ]
        ]);
        //object
        //dd(json_decode($response->getBody()->getContents()));
        //array
//        dd(json_decode($response->getBody()->getContents(),true));
        $university =  json_decode($response->getBody()->getContents(),true);
        return view('users.university')->with('university',$university);
    }

    public function editProfileView($id)
    {
        $profile = Db::table('MERCURY_USER')
            ->where('ID_USER','=',$id)
            ->get();
        return view('users.editProfile')->with('profile',$profile);
    }

    public function getProfileView()
    {
        $session = Session::get('user');
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
        Auth::logout();
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
            
            if($auth){
                Session::put('user',$auth);
                return redirect('chats');
            }
            else{
                Session::flash('alert-danger', 'Email or Password is incorrect.');
                return redirect('/');
            }
        }
    }

    public function processEditProfile(Request $request,$id)
    {
        $rules = array(
            'Name' =>'required',
            'Surname' =>'required',
            'Position' =>'required',
            'Mobile'=>'required',
            'Email'=>'required|email'
        );
        $message = [
            'Name.required'=>'Name is Required',
            'Surname.required'=>'SurName is Required',
            'Position.required'=>'Position is Required',
            'Mobile.required'=>'Mobile is Required',
            'Email.required'=>'Email is Required',
            'Email.email'=>'Email format not correct'
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

            $checkMobile = $this->checkMobileEdit($Mobile,$id);
            if($checkMobile>0){
                Session::flash('alert-danger', 'Mobile already to use');
                return redirect('register')->withinput();
            }
            $checkEmail = $this->checkEmailEdit($Email,$id);
            if($checkEmail>0){
                Session::flash('alert-danger', 'Email already to use');
                return redirect('register')->withInput();
            }

            Db::table('mercury_user')->where('ID_USER','=',$id)
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
            'Name' =>'required',
            'Surname' =>'required',
            'Position' =>'required',
            'Mobile'=>'required',
            'Email'=>'required|email',
            'Password'=>'required|confirmed',
            'Password_confirmation'=>'required'
        );
        $message = [
            'Name.required'=>'Name is Required',
            'Surname.required'=>'SurName is Required',
            'Position.required'=>'Position is Required',
            'Mobile.required'=>'Mobile is Required',
            'Email.required'=>'Email is Required',
            'Email.email'=>'Email format not correct',
            'Password.required'=>'Password is Required',
            'Password.confirmed'=>'Password not match',
            'Password_confirmation.required'=>'Password Confirm is Required'
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

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
