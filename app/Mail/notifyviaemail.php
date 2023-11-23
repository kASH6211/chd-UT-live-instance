<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class notifyviaemail extends Mailable
{
    use Queueable, SerializesModels;

    protected $sub;
    protected $reason;
    protected $body;
    protected $headerimage;
    protected $footertext;

    public function __construct($headerimage=null,$sub,$reason,$body,$footertext)
    {
        
        $this->sub=$sub;
        $this->headerimage=$headerimage;
        $this->reason=$reason;
        $this->body=$body;
        $this->footertext=$footertext;
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Notifyviaemail',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'mail.email',
    //     );
    // }

    public function build(){
        return $this->subject($this->sub)->view('mail.email')->with(
            [
                "Headerimage"=>$this->headerimage,
                "Subject"=>$this->subject,
                "Body"=>$this->body,
                "Reason"=>$this->reason,
                "Footer"=>$this->footertext,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
