<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentCategoryRequest;
use App\Models\PaymentCategory;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;



class PaymentCategoriesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_payment_categories , show_payment_categories')) {
            return redirect('admin/index');
        }

        $categories = PaymentCategory::query()->where('section', 1)
            ->when(\request()->keyword != null, function ($query) {
                // $query->where('name','like','%'.\request()->keyword .'%');
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.payment_categories.index', compact('categories'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_payment_categories')) {
            return redirect('admin/index');
        }

        return view('backend.payment_categories.create');
    }

    public function store(PaymentCategoryRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_payment_categories')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['created_by'] = auth()->user()->full_name;
        $input['section'] = 1;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $paymentCategory = PaymentCategory::create($input);

        // add images to media db and to path : public/assets/payments
        if ($request->images && count($request->images) > 0) {

            $i = 1; // $i is used for making sort to image 

            foreach ($request->images as $image) {

                // $file_name = Str::slug($request->name).".".$image->getClientOriginalExtension(); // will not used because product already created to db and slug is there by steps upove
                $file_name = $paymentCategory->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/payment_categories/' . $file_name);

                // get the real path of this image then resize its width to 500 and height let it aspect it with width
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100); //then make copy of this image in new path as $path say with new name as $file_name say with clear 100%

                // add this photos to db using photos relational function
                $paymentCategory->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++; // step ahead by one for sort new image 
            }
        }


        if ($paymentCategory) {
            return redirect()->route('admin.payment_categories.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.payment_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_payment_categories')) {
            return redirect('admin/index');
        }
        return view('backend.payment_categories.show');
    }

    public function edit($paymentCategory)
    {
        if (!auth()->user()->ability('admin', 'update_payment_categories')) {
            return redirect('admin/index');
        }

        $paymentCategory = PaymentCategory::where('id', $paymentCategory)->first();


        return view('backend.payment_categories.edit', compact('paymentCategory'));
    }

    public function update(PaymentCategoryRequest $request,  $paymentCategory)
    {
        if (!auth()->user()->ability('admin', 'update_payment_categories')) {
            return redirect('admin/index');
        }

        $paymentCategory = PaymentCategory::where('id', $paymentCategory)->first();

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['section'] = 1;

        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $paymentCategory->update($input);


        // edit images in photos db and in path : public/assets/products
        if ($request->images && count($request->images) > 0) {

            $i = $paymentCategory->photos->count() + 1; // $i is used for making sort to image 

            foreach ($request->images as $image) {

                // $file_name = Str::slug($request->name).".".$image->getClientOriginalExtension(); // will not used because product already created to db and slug is there by steps upove
                $file_name = $paymentCategory->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();
                $path = public_path('assets/payment_categories/' . $file_name);

                // get the real path of this image then resize its width to 500 and height let it aspect it with width
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100); //then make copy of this image in new path as $path say with new name as $file_name say with clear 100%

                // add this photos to db using photos relational function
                $paymentCategory->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);

                $i++; // step ahead by one for sort new image 
            }
        }

        if ($paymentCategory) {
            return redirect()->route('admin.payment_categories.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.payment_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($PaymentCategory)
    {
        if (!auth()->user()->ability('admin', 'delete_payment_categories')) {
            return redirect('admin/index');
        }

        $PaymentCategory = PaymentCategory::where('id', $PaymentCategory)->first();

        if ($PaymentCategory->photos->count() > 0) {
            foreach ($PaymentCategory->photos as $photo) {
                if (File::exists('assets/payment_categories/' . $photo->file_name)) {
                    unlink('assets/payment_categories/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $PaymentCategory->delete();


        if ($PaymentCategory) {
            return redirect()->route('admin.payment_categories.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.payment_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_products')) {
            return redirect('admin/index');
        }

        //find product from product table 
        $paymentCategory = PaymentCategory::findOrFail($request->payment_category_id);

        //find photos image from photos table 
        $image = $paymentCategory->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/payment_categories/' . $image->file_name)) {
            // delete image from path 
            unlink('assets/payment_categories/' . $image->file_name);
        }
        //delete image from db
        $image->delete();

        return true;
    }
}
