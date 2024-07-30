<?php

namespace App\Http\Livewire\Frontend\EventList;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EventReviewComponent extends Component
{

    use LivewireAlert;

    public $eventId;
    public $rating;
    public $title;
    public $message;
    public $ratingCounts = [];
    public $totalReviews;

    public function mount()
    {
        // Fetch the count for each rating level
        $this->ratingCounts = Review::where('reviewable_id', $this->eventId)
            ->where('reviewable_type', Course::class)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Calculate the total number of reviews
        $this->totalReviews = array_sum($this->ratingCounts);
    }

    public function render()
    {
        // Retrieve the course along with its reviews
        $event = Course::with('reviews')->find($this->eventId);

        // Calculate the average rating
        $averageRating = $event->reviews->avg('rating');

        // Get the reviews
        $reviews = $event->reviews;

        return view('livewire.frontend.event-list.event-review-component', compact('reviews', 'averageRating'));
    }

    public function storeReview()
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            session()->flash('review_error', __('transf.msg_reviewers_register_login'));
            return;
        }

        // Check if the user has already submitted a review for this course
        $existingReview = Review::where('user_id', auth()->user()->id)
            ->where('reviewable_id', $this->eventId)
            ->where('reviewable_type', Course::class)
            ->first();

        if ($existingReview) {
            session()->flash('review_error', 'You have already submitted a review for this course.');
            return;
        }

        $validatedData = $this->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create the review
        $review = new Review([
            'user_id' => auth()->user()->id,
            'reviewable_id' => $this->eventId,
            'reviewable_type' => Course::class,
            'name' => auth()->user()->full_name,
            'email' => auth()->user()->email,
            'title' => $this->title,
            'message' => $this->message,
            'rating' => $this->rating,
        ]);

        $review->save();

        // Refresh the rating counts after adding a new review
        $this->mount();

        $this->emit('reviewAdded');

        $this->reset(['rating', 'title', 'message']);

        $this->alert('success', __('Review submitted successfully!'));
    }
}
