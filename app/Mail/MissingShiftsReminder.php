<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class MissingShiftsReminder extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
	protected $event;
	protected $shifts;
	protected $url;
	
	
    /**
     * Create a new message instance.
     */
    public function __construct($user,$event,$shifts,$url)
    {
       $this->user = $user;
       $this->event = $event;   
       $this->shifts = $shifts; 
       $this->url  = $url;
   		
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel horaire(s) manquant(s)',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
    
        return new Content(
            markdown: 'emails.shifts.missingShiftReminder',
            with: [
            'user' => $this->user,
            'event' => $this->event,
            'shifts' => $this->shifts,
            'url' => $this->url,
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
