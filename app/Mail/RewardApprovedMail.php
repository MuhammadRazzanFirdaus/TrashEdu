<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RewardRedemption;

class RewardApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $redemption;

    public function __construct(RewardRedemption $redemption)
    {
        $this->redemption = $redemption;
    }

    public function build()
    {
        return $this->subject('Reward Anda Disetujui')
                    ->view('emails.reward-approved');
    }
}
