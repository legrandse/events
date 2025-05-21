<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Shift;


class UserShift extends Mailable
{
	
	public $shift;
	public $subject;
	public $icalPath;
	
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($shift,$subject,$icalPath)
    {
        $this->shift = $shift;
        $this->subject = $subject;
        $this->icalPath = $icalPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
    	  	
    	
        return new Content(
            markdown: 'emails.shifts.user',
            with: [
            'username' => $this->shift->user->firstname,
            'event' => $this->shift->event->name,
            'date' => date('d-m-Y',strtotime($this->shift->event->start)),
            'shift' => $this->shift,
            //'url' => $this->url.'#collapse'.$this->shift->event->id,
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
        return [
            Attachment::fromPath($this->icalPath)
                ->as(env('APP_NAME').'.ics')
                ->withMime('text/calendar'),
        ];
    }
}
