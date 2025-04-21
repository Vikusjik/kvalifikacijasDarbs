<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Consultation;

class ConsultationCancelled extends Notification
{
    use Queueable;

    protected $consultation;
    protected $reason;
    protected $student;

    public function __construct(Consultation $consultation, $reason, $student)
    {
        $this->consultation = $consultation;
        $this->reason = $reason;
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'student_name' => $this->student->name,
            'reason' => $this->reason,
            'consultation_date' => $this->consultation->date_time,
            'consultation_id' => $this->consultation->id,
        ];
    }
}
