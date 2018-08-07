<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeviceInWork extends Mailable
{
    use Queueable, SerializesModels;

    protected $device;
    protected $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($device, $address)
    {
        $this->device = $device;
        $this->address = $address;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->view('mail')
            ->with([
                'device'=> $this->device,
                'address'=> $this->address,
            ]);
    }
}
