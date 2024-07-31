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

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 15;


    public function index()
    {
        $main_sliders = Slider::with('firstMedia')
            ->orderBy('published_on', 'desc')
            ->Active()
            ->take(
                8
            )
            ->get();


        // Get instructors
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })
            ->active()
            ->HasCourses()
            ->inRandomOrder()
            ->take(10)
            ->get();

        // $events = Post::with('photos')->where('section', 1)->orderBy('created_at', 'ASC')->get();
        $events = Course::with('photos')->where('section', 2)->orderBy('created_at', 'ASC')->get();
        $posts = Post::with('photos')->where('section', 1)->orderBy('created_at', 'ASC')->get();

        $callActions = CallAction::with('photos')->get();

        // return view('backend.admin-login');

        return view('frontend.index', compact('main_sliders', 'instructors', 'events', 'posts', 'callActions'));
    }

    public function home()
    {
        return view('frontend.home');
    }

    public function courses_list($slug = null)
    {
        // return view('frontend.course-list', compact('courses', 'course_categories_menu'));
        return view('frontend.course-list', compact('slug'));
    }

    public function course_single($slug)
    {
        // Retrieve the text from the database
        $course  = Course::with('courseCategory', 'sections.lessons', 'photos', 'users', 'reviews')
            ->where('slug->' . app()->getLocale(), $slug)
            ->Active()
            ->ActiveCourseCategory()
            ->firstOrFail();


        // Trim the text to remove leading and trailing spaces
        $course->description = trim($course->description);
        // Get the first 200 characters
        $exposedText = substr($course->description, 0, 200);
        // Get the rest of the text
        $hiddenText = substr($course->description, 200);


        //get all related course that are the same of courseCategory of the this choisen course
        $related_courses = Course::with('firstMedia', 'photos', 'courseCategory')->whereHas('courseCategory', function ($query) use ($course) {
            $query->whereId($course->course_category_id)->whereStatus(true);
        })->inRandomOrder()
            ->Active()
            ->Course()
            ->where('id', '<>', $course->id)
            ->take(8)
            ->get();

        $latest_courses = Course::with('firstMedia', 'photos', 'courseCategory')
            ->orderBy('created_at', 'desc') // Order by creation date in descending order
            ->Active()
            ->Course()
            ->where('id', '<>', $course->id)
            ->take(4)
            ->get();

        $totalDurations = 0;
        foreach ($course->sections as $section) {
            $totalDurations +=  $section->lessons->sum('duration_minutes');
        }

        $hours = floor($totalDurations / 60);
        $minutes = $totalDurations % 60;




        // Generate WhatsApp share URL
        $whatsappShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($course->name . ': ' . route('frontend.course_single', $course->slug));

        return view('frontend.course-single', compact('course', 'exposedText', 'hiddenText', 'related_courses', 'latest_courses', 'whatsappShareUrl', 'totalDurations', 'hours', 'minutes'));
    }

    public function event_list($slug = null)
    {

        return view('frontend.event-list', compact('slug'));
    }

    public function event_single($slug)
    {
        $event = Course::with('photos', 'topics', 'requirements')
            ->where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();


        // Trim the text to remove leading and trailing spaces
        $event->description = trim($event->description);
        // Get the first 200 characters
        $exposedText = substr($event->description, 0, 200);
        // Get the rest of the text
        $hiddenText = substr($event->description, 200);

        // Generate WhatsApp share URL
        $whatsappShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($event->name . ': ' . route('frontend.event_single', $event->slug));

        return view('frontend.event-single', compact('event', 'exposedText', 'hiddenText', 'whatsappShareUrl'));
    }

    public function blog_list($slug = null)
    {
        return view('frontend.blog-list', compact('slug'));
    }

    public function blog_tag_list($slug = null)
    {
        return view('frontend.blog-tag-list', compact('slug'));
    }


    public function blog_single($slug)
    {
        $post = Post::with('photos', 'tags')
            ->where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();

        $latest_posts = Post::with('photos')->where('section', 1)->orderBy('created_at', 'ASC')->get();

        // Generate WhatsApp share URL
        $whatsappShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($post->name . ': ' . route('frontend.blog_single', $post->slug));

        return view('frontend.blog-single', compact('post', 'latest_posts',  'whatsappShareUrl'));
    }

    public function instructors_list($slug = null)
    {
        return view('frontend.instructors-list');
    }

    public function instructors_single($slug)
    {
        $instructor = User::whereId($slug)->first();

        // Trim the text to remove leading and trailing spaces
        $instructor->description = trim($instructor->description);
        // Get the first 200 characters
        $exposedText = substr($instructor->description, 0, 200);
        // Get the rest of the text
        $hiddenText = substr($instructor->description, 200);


        return view('frontend.instructors-single', compact('instructor', 'exposedText', 'hiddenText'));
    }

    public function shop_cart()
    {
        return view('frontend.shop-cart');
    }

    public function shop_checkout()
    {
        return view('frontend.shop-checkout');
    }

    public function shop_order_completed()
    {
        return view('frontend.shop-order-completed');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact_us()
    {
        return view('frontend.contact-us');
    }


    public function service()
    {
        return view('frontend.terms_of_service');
    }

    public function pages($slug)
    {
        $page = Page::where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();
        return view('frontend.pages', compact('page'));
    }
}
