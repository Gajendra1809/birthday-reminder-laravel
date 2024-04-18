<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DateController extends Controller
{

    /**
    * Display the user's home page with birthday information.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\View\View
    */
    public function home(Request $request){
        $useremail=$request->session()->get('uid')->email;

        //upcoming birthdays
        //$currentDate = Carbon::now();
        $birthday = Birthday::where('useremail', $useremail)
                    ->whereRaw("DATE_FORMAT(date, '%m%d') >= DATE_FORMAT(CURDATE(), '%m%d')")
                    ->orderByRaw("DATE_FORMAT(date, '%m%d')")
                    ->paginate(5);

        //all birthdates for a perticular user
        $data=Birthday::where('useremail', $useremail)
              ->orderByRaw("DATE_FORMAT(date, '%m%d')")
              ->get();
        
        return view("home",compact("birthday","data"));
    }


    /**
    * Create a new birthday record for the user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function create(Request $request){
        $request->validate([
            "name"=>"required",
            "date"=>"required",
        ]);
        $data=new Birthday();
        $data->useremail=$request->session()->get('uid')->email;
        $data->name= $request->name;
        $data->date= $request->date;
        $data->phone= $request->phone;

        try {
            $data->save();
            return redirect(route('home'))->with('success','Birthdate Added!');
        } catch(\Exception $e){
            return redirect(route('home'))->with('error','Birthdate Not Added!');
        }
    }


    /**
    * Delete a birthday record.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function delete(Request $request){
        $birthday= Birthday::where('id','=',$request->id);

        try {
            $birthday->delete();
            return redirect(route('home'))->with('success','Birthdate Deleted!');
        } catch(\Exception $e){
            return redirect(route('home'))->with('error','Birthdate Not Deleted!');  
        } 
    }

}
