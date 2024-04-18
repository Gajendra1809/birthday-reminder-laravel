<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Birthday;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{    

    /**
    * Handle the login request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function login(Request $request){
        $request->validate([
            "email"=> "required",
            "password"=> "required|min:5"
        ]);
        $user = User::where("email", $request->email)->first();
        if($user and $user->password==$request->password){
            //saving user identity in session
            $request->session()->put('uid',$user);
            return redirect('home');
        }else{
            return redirect(route('login'))->with('error','Invalid crediantials!');
        }
    }


    /**
    * Handle the register request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function register(Request $request){
        $request->validate([
            "name"=>"required",
            "email"=> "required",
            "password"=> "required|min:5",
            "phone"=> "required|min:10|numeric",
        ]);

        $user=new User();
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password= $request->password;
        $user->phone= $request->phone;

        try {
            $user->save();
            $request->session()->put('uid', $user);
            return redirect(route('login'))->with('success', 'User Registered!');
        } catch(\Exception $e){
            return redirect(route('register'))->with('error', 'Not Registered! May be email already exists');
        }
    }


    /**
    * Handle the logout request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function logout(Request $request){
        $request->session()->forget('uid');
        return redirect(route('login'))->with('success','Logged Out!');
    }


    //view for profile get request
    public function profile(Request $request){
        return view('profile');
    }


    /**
    * Handle the profile update request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function profilepost(Request $request){
        $request->validate([
            "name"=>"required",
            "email"=> "required",
            "phone"=> "required|min:10|numeric",
        ]);

          $data=User::findOrFail(session('uid')->id);
          $birthday = Birthday::where('useremail', session('uid')->email)->get();
          
          //updating the useremail in birthday table
          foreach($birthday as $d){
            $d->useremail=$request->email;
            $d->save();
          }
    
        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;

        try {
        $data->save(); 
        $request->session()->forget('uid');
        $request->session()->put('uid',$data);
        return redirect(route('profile'))->with('success','Changes saved!');
        } catch(\Exception $e){
        return redirect(route('profile'))->with('success','Changes Not saved!');
        }
    }
}
