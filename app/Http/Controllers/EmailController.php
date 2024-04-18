<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Birthday;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\EmailNotification;
use Carbon\Carbon;

class EmailController extends Controller
{

    /**
    * Send birthday reminders to users whose birthday is within the next 2 days.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function send(Request $request){

        $currentDate = Carbon::now();
        $upcomingDate = $currentDate->copy()->addDays(2); // Get the date 2 days from now

        // Compare only the month and day parts of the date field and get birthdays coming in next two days
        $person = Birthday::whereBetween(Birthday::raw("DATE_FORMAT(date, '%m-%d')"),
                                        [$currentDate->format('m-d'), $upcomingDate->format('m-d')])
                                        ->get();

        // Log::info($person);
        //creating email body for each birthday
        foreach($person as $p){
            $data=[
                'name'=>$p->name,
                'date'=>date('jS F', strtotime($p->date)),
                'phone'=>$p->phone
            ];

            // Sending email
           Notification::route('mail', $p->useremail)->notify(new EmailNotification($data));
           log::info('Email sent!');
        }
    }
}
