<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userData;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData, $order)
    {
        $this->userData = $userData;
        $this->order = $order;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('order', [
            'order' => $this->order
        ]);
    }
}
