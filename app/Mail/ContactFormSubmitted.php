<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
        public $subject;
        public $content;
    public function __construct($subject,$content)
    {
        
       $this->subject = $subject;
        $this->content = $content;
    }

    
    
   public function build()
{
    $content = $this->content;
    $data =  $this->from('anil.test341@gmail.com')->subject($this->subject)->view('emails.contact-form-submitted', compact('content'));
    dd($data);
    return $data;
}

 }
