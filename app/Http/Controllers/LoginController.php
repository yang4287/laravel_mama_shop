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

   
    public function loginCheck(Request $request)
    {
        // $input = $request->all();
        try {
            $this->authService->index($request);
            return redirect('/admin/product');
        }
        catch(Exception $e){
            
            return redirect('/admin/login')->withErrors($e)->withInput();
        }
       
        
    }

    public function logout(Request $request)
    {
        
        $request->session()->flush();
        return redirect('/admin/login');

      
    }
}
