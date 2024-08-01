<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CallAction;
use App\Models\Course;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class FrontendController extends Controller
{

    public function index()
    {
        return view('backend.admin-login');
    }
}
