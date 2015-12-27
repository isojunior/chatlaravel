<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function getRegisterView()
    {
        return view('users.register');
    }

    public function getLoginView()
    {
        return view('users.login');
    }

    public function processLogin()
    {

    }

    public function checkMobile($mobile)
    {
        $query = Db::table('MERCURY_USER')
            ->where('TELEPHONE','=',$mobile)
            ->count();
        return $query;
    }
    public function checkEmail($email)
    {
        $query = Db::table('MERCURY_USER')
            ->where('EMAIL','=',$email)
            ->count();
        return $query;
    }
    public function processRegister(Request $request)
    {
        //
        $rules = array(
            'regisName' =>'required',
            'regisSurname' =>'required',
            'regisPosition' =>'required',
            'regisMobile'=>'required',
            'regisEmail'=>'required|email',
            'regisPassword'=>'required|confirmed',
            'regisPassword_confirmation'=>'required'
        );
        $message = [
            'regisName.required'=>'กรุณาระบุชื่อ',
            'regisSurname.required'=>'กรุณาระบุนามสกุล',
            'regisPosition.required'=>'กรุณาระบุตำแหน่ง',
            'regisMobile.required'=>'กรุณาระบุหมายเลขโทรศัพท์',
            'regisEmail.required'=>'กรุณาระบุอีเมล์',
            'regisEmail.email'=>'กรุณาระบุอีเมล์ให้ถูกต้อง',
            'regisPassword.required'=>'กรุณาระบุรหัสผ่าน',
            'regisPassword.confirmed'=>'รหัสผ่านไม่ตรง',
            'regisPassword_confirmation.required'=>'กรุณาระบุรหัสผ่าน'
        ];
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails())
        {
            return redirect('register')->withErrors($validator)->withInput();
        }else{
            $regisName = $request->input('regisName');
            $regisSur = $request->input('regisSurname');
            $regisPos = $request->input('regisPosition');
            $regisMobile = $request->input('regisMobile');
            $regisEmail = $request->input('regisEmail');
            $regisPass = $request->input('regisPassword');

            $checkmobile = $this->checkMobile($regisMobile);
            if($checkmobile>0)
            {
                Session::flash('alert-danger', 'หมายเลขนี้ถูกใช้งานแล้ว');
                return redirect('register')->withinput();
            }
            $checkemail = $this->checkEmail($regisEmail);
            if($checkemail>0)
            {
                Session::flash('alert-danger', 'อีเมล์นี้ถูกใช้งานแล้ว');
                return redirect('register')->withInput();
            }

            Db::table('mercury_user')->insert(
                [
                    'FIRST_NAME'=>$regisName,
                    'LAST_NAME'=>$regisSur,
                    'TELEPHONE'=>$regisMobile,
                    'EMAIL'=>$regisEmail,
                    'PASSWORD'=>$regisPass,
                    'POSITION'=>$regisPos
                ]
            );
            Session::flash('alert-success', 'สมัครสมาชิกเรียบร้อยแล้ว');
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
