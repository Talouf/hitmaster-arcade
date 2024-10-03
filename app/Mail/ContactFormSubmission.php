<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function build()
    {
        return $this->view('emails.contact-form-submission')
                    ->subject('Nouveau message de contact');
    }
}