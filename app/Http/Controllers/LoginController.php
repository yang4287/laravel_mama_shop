<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Services\AuthService;



class LoginController  extends Controller
{

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {

        return view('admin.login');
    }

    public function member_index()
    {
        return view('member.login');
    }

    public function memberLoginCheck(Request $request)
    {
        try {

            $this->authService->index($request);
            return redirect('/');
        } catch (Exception $e) {
            return redirect('/member/login')->withErrors($e)->withInput();
        }
    }


    public function loginCheck(Request $request)
    {

        try {
            $this->authService->index($request);
            return redirect('/admin/product');
        } catch (Exception $e) {

            return redirect('/admin/login')->withErrors($e)->withInput();
        }
    }

    public function logout(Request $request)
    {
        if (session('account_level') != 0){
            $request->session()->flush();
            return redirect('/');
        }
        $request->session()->flush();
        return redirect('/admin/login');
    }
}
