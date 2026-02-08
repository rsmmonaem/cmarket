<?php

namespace App\Mail;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionEarned extends Mailable
{
    use Queueable, SerializesModels;

    public $commission;

    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
    }

    public function build()
    {
        return $this->subject('Commission Earned - ৳' . number_format($this->commission->amount, 2))
            ->view('emails.commission-earned');
    }
}
