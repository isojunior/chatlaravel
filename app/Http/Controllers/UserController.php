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
            'regis_name' =>'required',
            'regis_surname' =>'required',
            'regis_position' =>'required',
            'regis_mobile'=>'required',
            'regis_email'=>'required|email',
            'regis_password'=>'required|confirmed',
            'regis_password_confirmation'=>'required'
        );
        $message = [
            'regis_name.required'=>'กรุณาระบุชื่อ',
            'regis_surname.required'=>'กรุณาระบุนามสกุล',
            'regis_position.required'=>'กรุณาระบุตำแหน่ง',
            'regis_mobile.required'=>'กรุณาระบุหมายเลขโทรศัพท์',
            'regis_email.required'=>'กรุณาระบุอีเมล์',
            'regis_email.email'=>'กรุณาระบุอีเมล์ให้ถูกต้อง',
            'regis_password.required'=>'กรุณาระบุรหัสผ่าน',
            'regis_password.confirmed'=>'รหัสผ่านไม่ตรง',
            'regis_password_confirmation.required'=>'กรุณาระบุรหัสผ่าน'
        ];
        $validator = Validator::make($request->all(),$rules,$message);
        if($validator->fails())
        {
            return redirect('register')->withErrors($validator)->withInput();
        }else{
            $regis_name = $request->input('regis_name');
            $regis_sur = $request->input('regis_surname');
            $regis_pos = $request->input('regis_position');
            $regis_mobile = $request->input('regis_mobile');
            $regis_email = $request->input('regis_email');
            $regis_pass = $request->input('regis_password');

            $checkmobile = $this->checkMobile($regis_mobile);
            if($checkmobile>0)
            {
                Session::flash('alert-danger', 'หมายเลขนี้ถูกใช้งานแล้ว');
                return redirect('register')->withErrors()->withinput();
            }
            $checkemail = $this->checkEmail($regis_email);
            if($checkemail>0)
            {
                Session::flash('alert-danger', 'อีเมล์นี้ถูกใช้งานแล้ว');
                return redirect('register')->withErrors()->withInput();
            }

            Db::table('mercury_user')->insert(
                [
                    'FIRST_NAME'=>$regis_name,
                    'LAST_NAME'=>$regis_sur,
                    'TELEPHONE'=>$regis_mobile,
                    'EMAIL'=>$regis_email,
                    'PASSWORD'=>$regis_pass,
                    'POSITION'=>$regis_pos
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
