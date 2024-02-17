<?php

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KickedOutNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $group;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group, User $user)
    {
        $this->group = $group;
        $this->user = $user;
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
        return (new MailMessage)
            ->priority(2)
            ->subject("Csoport Értesítés - SZoESE E-Sport")
            ->greeting('Kedves ' . $this->user->first_name . '!')
            ->line('Értesítelek, hogy a(z) ' . $this->group->game . ' nevű csoportból el lettél távolítva egy adminisztrátor által.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}