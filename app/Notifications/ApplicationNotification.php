<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationNotification extends Notification implements ShouldQueue
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
            ->priority(1)
            ->subject("Új jelentkezés - SZoESE E-Sport")
            ->greeting('Kedves ' . $this->application->group->leader->first_name . '!')
            ->line('Új jelentkezés érkezett a(z) ' . $this->application->group->game . ' csoportodba.')
            ->line('A Jelentkező adatai:')
            ->lines([
                'Név: ' . $this->application->user->full_name(),
                'Felhasználónév: ' . $this->application->user->username,
                'Email cím: ' . $this->application->user->email,
                'Jelentkezés dátuma: ' . $this->application->created_at
            ])
            ->line('Vedd fel a kapcsolatot a jelentkezővel az email címén keresztül, majd a weboldalon fogadd el vagy utasítsd el a jelentkezését!')
            ->action('Jelentkezés Kezelése', url(route('dashboard.application.index')));
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

    public function shouldSend(object $notifiable, string $channel): bool
    {
        $application = Application::find($this->application->id);

        if (!$application) {
            return false;
        }

        return true;
    }
}