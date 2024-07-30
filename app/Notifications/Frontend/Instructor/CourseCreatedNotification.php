<?php

namespace App\Notifications\Frontend\Instructor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $course;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id'          =>  $this->course->id,
            'course_title'          =>  $this->course->title,
            'last_transaction'  =>  $this->course->course_status,
            'order_url'     =>  route('admin.courses.show', $this->course->id),
            'created_date'      =>  $this->course->created_at->format('M d, Y'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data'  => [
                'course_id'          =>  $this->course->id,
                'course_title'          =>  $this->course->title,
                'last_transaction'  =>  $this->course->course_status,
                'order_url'     =>  route('admin.courses.show', $this->course->id),
                'created_date'      =>  $this->course->created_at->format('M d, Y'),
            ]
        ]);
    }
}
