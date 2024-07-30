<?php

namespace App\Notifications\Backend\Courses;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $course;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Course $course)
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


    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    public function toDatabase($notifiable)
    {
        return [
            'course_id'          =>  $this->course->id,
            'course_title'          =>  $this->course->title,
            'last_transaction'  =>  $this->course->course_status,
            'order_url'         =>  route('instructor.dashboard'),
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
                'order_url'         =>  route('instructor.dashboard'),
                'created_date'      =>  $this->course->created_at->format('M d, Y'),
            ]
        ]);
    }
}
