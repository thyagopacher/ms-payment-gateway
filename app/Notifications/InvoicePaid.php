<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Payment $payment)
    {
        $this->afterCommit();
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
            ?? $this->payment->person->name
            ?? 'Cliente';

        return (new MailMessage)
            ->subject("Pagamento Confirmado - #" . $this->payment->id)
            ->greeting('Olá, ' . $name)
            ->line('Seu pagamento foi confirmado com sucesso!')
            ->line('**Valor:** R$ ' . number_format($this->payment->amount, 2, ',', '.'))
            ->line('**Método:** ' . ucfirst($this->payment->payment_method))
            ->line('**Data do pagamento:** ' . $this->payment->updated_at->format('d/m/Y H:i'))
            ->action('Ver Detalhes do Pagamento', url('/payments/' . $this->payment->id))
            ->line('Obrigado por escolher nossa empresa!');
    }

    public function shouldSend(object $notifiable, string $channel): bool
    {
        return $this->payment->isPaid();
    }

    public function tags(): array
    {
        return ['payment', 'paid', "payment-". $this->payment->id];
    }

}
