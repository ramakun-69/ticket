<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateTicketNotification extends Notification
{
    use Queueable;
    protected $ticket;
    /**
     * Create a new notification instance.
     */
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
            ->subject(__('New Support Ticket : '). $this->ticket->ticket_number)
            ->view('email.create-ticket', [
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
            'title' => __("New Ticket Support"),
            'messages' => __("There are new tickets for from ") . $this->ticket->user->name,
            'type' => $this->ticket->type
        ];
    }
}
