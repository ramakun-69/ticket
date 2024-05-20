<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProcessTicketNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
            ->subject(__('Process Support Ticket : ') . $this->ticket->ticket_number)
            ->view('email.process-ticket', [
                'ticket' => $this->ticket,
                'url' => route('ticket.index')
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => __("Notification"),
            'messages' => __("Support Tickets Can Be Processed"),
            'type' => $this->ticket->type
        ];
    }
}
