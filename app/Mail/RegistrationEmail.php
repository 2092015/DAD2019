<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hash;
use Illuminate\Support\Facades\URL;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $user;

    protected $url;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = $url = URL::to('/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("postmaster@mail.restadadurant.tk")->view('email')
            ->with([
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'url' => $this->url
            ]);
    }
}
