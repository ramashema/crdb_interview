<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $subscriber_full_name;
    public $service_type;
    public $verification_status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber_full_name, $service_type, $verification_status)
    {
        $this->subscriber_full_name = $subscriber_full_name;
        $this->service_type = $service_type;
        $this->verification_status = $verification_status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = [
          'subscriber_full_name'=> $this->subscriber_full_name,
           'service_type' => $this->service_type,
            'verification_status'=>$this->verification_status
        ];
        return $this->markdown('emails.subscriptionNotification')->with('details', $details);
    }
}
