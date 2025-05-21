<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Event;



class ShiftSent extends Mailable
{
    use Queueable, SerializesModels; 
	
	protected $user;
	protected $events;
	protected $url;
	
    /**
     * Create a new message instance.
     */
    public function __construct($user,$events,$url)
    {
        $this->user = $user; 
        $this->events = $events;
        $this->url = $url; 
        
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appel aux bénévoles',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
    	
    	//$eventname = Event::find($this->events->event_id);
    	
    	return new Content(
            markdown: 'emails.shifts.sent',
            with: [
            'username' => $this->user['firstname'],
            'event' => $this->events->name,
            'date' => date('d-m-Y',strtotime($this->events->start)),
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
