<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionNotification;

class SubscriberController extends Controller
{
    // create subscribers
    public function create(Request $request){
        // validate data
        $this->validate($request, [
            'first_name'=>'required|max:255',
            'middle_name'=>'max:255',
            'last_name'=>'required',
            'dob'=>'required|date',
            'email'=>'required|email|unique',
            'phone'=>'required',
            'service_type'=>'required',
            'subscription_status'=>'required',
        ]);

        // post in the database
        $new_subscriber = $request->agent()->subscribers()->create([
            'first_name'=>$request->input('first_name'),
            'middle_name'=>$request->input('middle_name'),
            'last_name'=>$request->input('last_name'),
            'dob'=>$request->input('dob'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'service_type'=>$request->input('service_type'),
            'subscription_status'=>$request->input('subscription_status'),
        ]);

        // check if new sub have been created
        if ($new_subscriber == null){
           $agent_response = [
               'error'=>'Registration Failed something wrong with the system'
           ];

           $status_code = 500;
        } else{
            $agent_response = [
                'success'=>'Subscriber registered, waiting for verification process'
            ];

            $status_code = 200;
        }

        return response($agent_response, $status_code );
    }

    // load all subscribers
    public function all_subscribers(){
        return Subscriber::all();
    }

    // verify subscriber
    public function verify(Request $request, Subscriber $subscriber){
        // Staff verify an subscriber_status
        $this->validate($request, [
            'subscription_status'=>'required'
        ]);

        // update the status of subscriber in the database
        $subscriber->subscription_status = $request->input('subscription_status');
        $updated = $subscriber->update();

        if ($updated){
           // get subscriber current status send an email
            $verification_status = $subscriber->subscription_status;

            //send email about the status
            $agent = 'Stephen.Mtenga@crdbbank.co.tz';
            $customer = 'Aloyce.Mwitwa@crdbbank.co.tz';
            $subscriber_full_name = $subscriber->first_name." ".$subscriber->last_name;
            $service_type = $subscriber->service_type;

            // send email to subscribers
            Mail::to($customer)->cc($agent)->send( new SubscriptionNotification($subscriber_full_name, $service_type, $verification_status));

            return redirect('subscription_requests')->with('message','Customer and Agent has been notified' );
        } else {

        }
    }
}
