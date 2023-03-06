<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
         
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
  
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        } else {
            if (Auth::attempt($request->only(["email", "password"]))) {
                return response()->json([
                    "status" => true, 
                    "redirect" => url("admin/dashboard")
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "errors" => ["Invalid credentials"]
                ]);
            }
        }
    }
        
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
            'image' => 'required|mimes:jpeg,png,jpg,gif'
        ]);
  
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        if($request->file()){
            $data['image']  = $request->file('image')->store(
                'assets/users/','public'
            );
        }
        $user = User::create($data);
  
        Auth::login($user);
  
        return response()->json([
            "status" => true, 
            "redirect" => url("admin/dashboard")
        ]);
        
    }      
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
    
        return Redirect('login');
    }
}
