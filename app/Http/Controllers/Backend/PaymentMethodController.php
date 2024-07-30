<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentMethodRequest;
use App\Models\PaymentMethod;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentMethodController extends Controller
{
    
    public function index()
    {
        if(!auth()->user()->ability('admin','manage_payment_methods , show_payment_methods')){
            return redirect('admin/index');
        }

        $payment_methods = PaymentMethod::query()
        ->when(\request()->keyword != null , function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status != null , function($query){
            $query->where('status',\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' , \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);
        
        return view('backend.payment_methods.index',compact('payment_methods'));
        
    } 

    public function create()
    {
        if(!auth()->user()->ability('admin','create_payment_methods')){
            return redirect('admin/index');
        }

        return view('backend.payment_methods.create');
    }


    public function store(PaymentMethodRequest $request)
    {
        if(!auth()->user()->ability('admin','create_payment_methods')){
            return redirect('admin/index');
        }

        if( $request->validated() ){

            //save all except some 
            $payment_method = PaymentMethod::create( $request->except('images' ,'published_on','published_on_time','_token', 'submit'));

            // save the others 
            $published_on = $request->published_on.' '.$request->published_on_time;
            $published_on = new DateTimeImmutable($published_on);
            $payment_method->published_on = $published_on;
            $payment_method->save();

            // add images to photos db and to path : public/assets/payment_methods
            if($request->images && count( $request->images) > 0){

                $i = 1; // $i is used for making sort to image 

                foreach ($request->images as $image) {
                    
                    $file_name = $payment_method->slug. '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                    $file_size = $image->getSize();
                    $file_type = $image->getMimeType();
                    $path = public_path('assets/payment_methods/' . $file_name);
                    
                    // get the real path of this image then resize its width to 500 and height let it aspect it with width
                    Image::make($image->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);//then make copy of this image in new path as $path say with new name as $file_name say with clear 100%

                    // add this photos to db using photos relational function
                    $payment_method->photos()->create([
                        'file_name' =>$file_name,
                        'file_size' =>$file_size,
                        'file_type' =>$file_type,
                        'file_status' => 'true',
                        'file_sort' =>$i,
                    ]); 

                    $i++; // step ahead by one for sort new image 
                }
            }


            return redirect()->route('admin.payment_methods.index')->with([
                'message' => 'created successfully',
                'alert-type' => 'success'
            ]);
        
        }else{
        
            return redirect()->route('admin.payment_methods.index')->with([
                'message' => 'Something wrong',
                'alert-type' => 'danger'
            ]);
        }
        
        // PaymentMethod::create($request->validated());

       
    }
    
    public function show(PaymentMethod $payment_method)
    {
        if(!auth()->user()->ability('admin','display_payment_methods')){
            return redirect('admin/index');
        }
        return view('backend.payment_methods.show',compact('payment_method'));
    } 

    public function edit(PaymentMethod $payment_method)
    {
        if(!auth()->user()->ability('admin','update_payment_methods')){
            return redirect('admin/index');
        }

        return view('backend.payment_methods.edit',compact('payment_method'));
    }
    
    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        if(!auth()->user()->ability('admin','update_payment_methods')){
            return redirect('admin/index');
        }

        if($request->validated()){

            //update all except some 
            $payment_method->update($request->except('images' ,'published_on','published_on_time','_token', 'submit'));

            // update the others 
            $published_on = $request->published_on.' '.$request->published_on_time;
            $published_on = new DateTimeImmutable($published_on);
            $payment_method->published_on = $published_on;
            $payment_method->save();

            // edit images in photos db and in path : public/assets/payment_methods
            if($request->images && count( $request->images) > 0){

                $i = $payment_method->photos->count() + 1; // $i is used for making sort to image 

                foreach ($request->images as $image) {
                    
                    $file_name = $payment_method->slug. '_' . time() . $i . '.' . $image->getClientOriginalExtension(); // time() and $id used to avoid repeating image name 
                    $file_size = $image->getSize();
                    $file_type = $image->getMimeType();
                    $path = public_path('assets/payment_methods/' . $file_name);
                    
                    Image::make($image->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);

                    $payment_method->photos()->create([
                        'file_name' =>$file_name,
                        'file_size' =>$file_size,
                        'file_type' =>$file_type,
                        'file_status' => 'true',
                        'file_sort' =>$i,
                    ]); 

                    $i++; // step ahead by one for sort new image 
                }
            }

            return redirect()->route('admin.payment_methods.index')->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success'
            ]);
        
        }else{
            return redirect()->route('admin.payment_methods.index')->with([
                'message' => 'something went wrong',
                'alert-type' => 'danger'
            ]);
        }
        
    }

    public function destroy(PaymentMethod $payment_method)
    {
        if(!auth()->user()->ability('admin','delete_payment_methods')){
            return redirect('admin/index');
        }

        if($payment_method->photos->count() > 0){
            foreach($payment_method->photos as $photo){
                if(File::exists('assets/payment_methods/' . $photo->file_name)){
                    unlink('assets/payment_methods/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $payment_method->delete();


        return redirect()->route('admin.payment_methods.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request){

        if(!auth()->user()->ability('admin','delete_payment_methods')){
            return redirect('admin/index');
        }

        //find payment_method from payment_method table 
         $payment_method = PaymentMethod::findOrFail($request->payment_method_id);

         //find photos image from photos table 
         $image = $payment_method->photos()->where('id',$request->image_id)->first();

         if(File::exists('assets/payment_methods/' . $image->file_name)){
            // delete image from path 
             unlink('assets/payment_methods/' . $image->file_name);
         }
            //delete image from db
            $image->delete();

         return true;

    }

  
}
