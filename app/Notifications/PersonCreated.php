<?php

namespace App\Notifications;

use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Person $person)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $name = $notifiable->name
            ?? $notifiable->person->name
            ?? $this->person->name
            ?? 'Cliente';

        return (new MailMessage)
            ->subject("Perfil criado - #" . $this->person->id)
            ->greeting('Olá, ' . $name)
            ->line('Seu perfil foi criado com sucesso!')
            ->line('Boas compras!');
    }

    public function shouldSend(object $notifiable, string $channel): bool
    {
        return $this->person->wasRecentlyCreated;
    }

    public function tags(): array
    {
        return ['person', 'created', "person-". $this->person->id];
    }
}
