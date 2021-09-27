<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $subscriber_full_name;
    public $service_type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$subscriber_full_name)
    {
        $this->details = $details;
        $this->subscriber_full_name = $subscriber_full_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.subscriptionNotification')->with('details', $this->details);
    }
}
