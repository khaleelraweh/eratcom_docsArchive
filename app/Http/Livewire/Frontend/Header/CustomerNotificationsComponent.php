<?php

namespace App\Http\Livewire\Frontend\Header;

use Livewire\Component;

class CustomerNotificationsComponent extends Component
{


    public $unreadNotificationsCount = '';
    public $unreadNotifications;
    public $unreadCoursesNotifications;
    public $unreadOrdersNotifications;

    public $activeTab = 'instructor'; // Default active tab

    // to refresh the notification count in realtime 
    public function getListeners(): array
    {
        $userId = auth()->id();
        return [
            "echo-notification:App.Models.User.{$userId},notification" => 'mount'
        ];
    }

    public function mount()
    {
        $this->unreadNotificationsCount = auth()->user()->unreadNotifications->count();
        $this->unreadNotifications = auth()->user()->unreadNotifications;

        // Filter notifications for courses and orders
        $this->unreadCoursesNotifications = $this->unreadNotifications->filter(function ($notification) {
            return isset($notification->data['course_id']);
        });



        $this->unreadOrdersNotifications = $this->unreadNotifications->filter(function ($notification) {
            return isset($notification->data['order_id']);
        });
    }


    // to mark notification to readed on click on it 
    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        $notification->markAsRead();
        return redirect()->to($notification->data['order_url']);
    }

    public function render()
    {
        return view('livewire.frontend.header.customer-notifications-component');
    }
}
