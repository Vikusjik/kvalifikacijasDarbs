<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Consultation;

class ConsultationUpdatedNotification extends Notification
{
    use Queueable;

    protected $consultation;
    protected $type; // "updated" or "deleted"

    public function __construct(Consultation $consultation, $type)
    {
        $this->consultation = $consultation;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        if ($this->type === 'updated') {
            $message = 'Konsultācijas laiks tika mainīts uz ' . $this->consultation->date_time->format('d.m.Y H:i');
        } else {
            $message = 'Konsultācija tika atcelta';
        }

        return [
            'message' => $message,
            'consultation_id' => $this->consultation->id,
        ];
    }
}
