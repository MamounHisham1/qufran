<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class Fatwa extends Notification
{
    public function __construct(
        public string $userName,
        public string $fatwaTitle,
    ) {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'New Fatwa Request',
            'message' => "{$this->userName} has requested a fatwa: {$this->fatwaTitle}",
            'icon' => 'heroicon-o-document-text',
        ];
    }
}
