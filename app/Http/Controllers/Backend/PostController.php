<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PostRequest;
use App\Models\CourseCategory;
use App\Models\Post;
use App\Models\Tag;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_posts , show_posts')) {
            return redirect('admin/index');
        }

        $posts = Post::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.posts.index', compact('posts'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }

        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);
        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);

        return view('backend.posts.create', compact('tags', 'course_categories'));
    }

    public function store(PostRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }


        $input['title']              =   $request->title;
        $input['description']        =   $request->description;
        $input['course_category_id'] =   $request->course_category_id;

        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $posts = Post::create($input);

        $posts->tags()->attach($request->tags);

        if ($request->images && count($request->images) > 0) {

            $i = 1;

            foreach ($request->images as $image) {

                $file_name = $posts->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/posts/' . $file_name);

                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $posts->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }

        if ($posts) {
            return redirect()->route('admin.posts.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_posts')) {
            return redirect('admin/index');
        }
        return view('backend.posts.show');
    }

    public function edit($post)
    {
        if (!auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }

        $course_categories = CourseCategory::whereStatus(1)->get(['id', 'title']);

        $post = Post::where('id', $post)->first();

        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);

        return view('backend.posts.edit', compact('post', 'tags', 'course_categories'));
    }

    public function update(PostRequest $request,  $post)
    {


        if (!auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }

        $post = Post::where('id', $post)->first();

        $input['title']                         =   $request->title;
        $input['description']                   =   $request->description;
        $input['course_category_id']   =   $request->course_category_id;

        // always added 
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        // end of always added 

        $post->update($input);

        $post->tags()->sync($request->tags);

        if ($request->images && count($request->images) > 0) {
            $i = $post->photos->count() + 1;

            foreach ($request->images as $image) {

                $file_name = $post->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/posts/' . $file_name);

                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $post->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++;
            }
        }


        if ($post) {
            return redirect()->route('admin.posts.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.posts.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($post)
    {
        if (!auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin/index');
        }

        $post = Post::where('id', $post)->first();

        if ($post->photos->count() > 0) {
            foreach ($post->photos as $photo) {
                if (File::exists('assets/posts/' . $photo->file_name)) {
                    unlink('assets/posts/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $post->delete();

        if ($post) {
            return redirect()->route('admin.posts.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_courses')) {
            return redirect('admin/index');
        }

        $post = Post::findOrFail($request->course_id);

        $image = $post->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/posts/' . $image->file_name)) {
            unlink('assets/posts/' . $image->file_name);
        }
        $image->delete();

        return true;
    }
}
