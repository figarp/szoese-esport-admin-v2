<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
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
            ->subject("Jelentkezés Elutasítva ❌ - SZoESE E-Sport")
            ->greeting('Kedves ' . $this->application->user->first_name . '!')
            ->line('Sajnálattal értesítelek, hogy a ' . $this->application->group->game . ' nevű csoportba a jelentkezésed elutasításra került.')
            ->line('Amennyiben kérdésed van, Discordon fel tudod venni a kapcsolatot az érintett csoportvezetővel!')
            ->action('Csatlakozok!', url('https://discord.gg/H4gEMH5t6F'));
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