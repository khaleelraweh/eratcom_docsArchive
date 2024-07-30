<?php

namespace App\Http\Livewire\Frontend\Blogs;

use App\Models\CourseCategory;
use App\Models\Post;
use App\Models\Tag;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BlogListComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 4;

    public $slug;

    //To filter by categories choosen 
    public $categoryInputs = [];

    public $searchQuery = '';
    public $selectedNames = [];

    protected $queryString = ['categoryInputs', 'searchQuery'];

    public function resetFilters()
    {
        $this->categoryInputs = [];

        $this->searchQuery = '';
        $this->selectedNames = [];
    }

    public function render()
    {
        $tags = Tag::query()->whereStatus(1)->where('section', 3)->get();
        $posts = Post::with('photos');

        if ($this->slug == null) {
            $posts = $posts->ActiveCourseCategory();

            if ($this->categoryInputs != null) {
                $courseCategoryIds = CourseCategory::whereIn('slug->' . app()->getLocale(), $this->categoryInputs)->pluck('id')->toArray();
                $posts = $posts->whereIn('course_category_id', $courseCategoryIds);
            }
        } else {

            if ($this->categoryInputs == null) {
                $course_category = CourseCategory::where('slug->' . app()->getLocale(), $this->slug)
                    ->whereStatus(true)
                    ->first();
                $posts = $posts->where('course_category_id', $course_category->id);
            } else {
                $courseCategoryIds = CourseCategory::whereIn('slug->' . app()->getLocale(), $this->categoryInputs)->pluck('id')->toArray();
                $posts = $posts->whereIn('course_category_id', $courseCategoryIds);
            }
        }

        $posts = $posts
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'LIKE', '%' . $this->searchQuery . '%');
                });
            })
            ->Blog()->active()->paginate($this->paginationLimit);

        $categories_menu = CourseCategory::withCount(['posts' => function ($query) {
            $query->where('section', 1);
        }])->whereHas('posts', function ($query) {
            $query->where('section', 1);
        })->get();

        $total_Posts = Post::query()->Blog()->count();

        $recent_posts = Post::with('photos')->Blog()->orderBy('created_at', 'DESC')->take(3)->get();



        return view(
            'livewire.frontend.blogs.blog-list-component',
            [
                'posts'             =>  $posts,
                'categories_menu'   =>  $categories_menu,
                'total_Posts'       =>  $total_Posts,
                'recent_posts'      =>  $recent_posts,
                'tags'              =>  $tags,
            ]
        );
    }
}
