<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_reviews , show_reviews')) {
            return redirect('admin/index');
        }

        $reviews = Review::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        if (!auth()->user()->ability('admin', 'update_reviews')) {
            return redirect('admin/index');
        }

        return view('backend.reviews.edit', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        if (!auth()->user()->ability('admin', 'update_reviews')) {
            return redirect('admin/index');
        }

        $review->update($request->validated());


        return redirect()->route('admin.reviews.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(review $review)
    {
        if (!auth()->user()->ability('admin', 'delete_reviews')) {
            return redirect('admin/index');
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
