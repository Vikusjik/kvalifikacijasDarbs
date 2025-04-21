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
    protected $teacher;

    public function __construct(Consultation $consultation, $type)
    {
        $this->consultation = $consultation;
        $this->type = $type;
        // Проверка наличия учителя перед установкой
        $this->teacher = $consultation->teacher ? $consultation->teacher : null; 
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        // Проверка на null для учителя
        $teacherName = $this->consultation->creator ? $this->consultation->creator->name : 'Nezināms skolotājs';

        if ($this->type === 'updated') {
            $message = 'Konsultācijas laiks tika mainīts uz ' . $this->consultation->date_time->format('d.m.Y H:i') . 
                       ' (Skolotājs: ' . $teacherName . ')';
        } else {
            $message = 'Konsultācija tika atcelta (Skolotājs: ' . $teacherName . ')';
        }

        return [
            'message' => $message,
            'consultation_id' => $this->consultation->id,
            'teacher_name' => $teacherName,
            'consultation_date' => $this->consultation->date_time,
        ];
    }
}
