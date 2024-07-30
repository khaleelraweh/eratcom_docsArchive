<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class InstructorController extends Controller
{
    public function dashboard()
    {
        return view('frontend.instructor.dashboard');
    }

    public function profile()
    {
        $instructor = Auth::user();
        $specializations = Specialization::get(['id', 'name']);
        $instructorSpecializations = $instructor->specializations->pluck(['id'])->toArray();

        return view('frontend.instructor.profile', compact('specializations', 'instructorSpecializations'));
    }

    public function update_profile(ProfileRequest $request)
    {

        $user = Auth()->user();

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;

        $data['biography'] = $request->biography;
        $data['facebook'] = $request->facebook;
        $data['twitter'] = $request->twitter;
        $data['instagram'] = $request->instagram;
        $data['linkedin'] = $request->linkedin;
        $data['youtube'] = $request->youtube;
        $data['website'] = $request->website;

        if (!empty($request->password) && !Hash::check($request->password, $user->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if ($user_image = $request->file('user_image')) {
            if ($user->user_image != '') {
                if (File::exists('assets/users/' . $user->user_image)) {
                    unlink('assets/users/' . $user->user_image);
                }
            }

            $file_name = $user->username . '.' . $user_image->extension();
            $path = public_path('assets/users/' . $file_name);
            Image::make($user_image->getRealPath())->resize(300, null, function ($constraints) {
                $constraints->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $file_name;
        }

        $user->update($data);



        //update specifications
        if (isset($request->specializations) && count($request->specializations) > 0) {
            $user->specializations()->sync($request->specializations);
        }

        // toast('Profile updated' , 'success');
        return back();
    }

    public function remove_profile_image()
    {
        $user = auth()->user();

        if ($user->user_image != '') {
            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);
            }

            $user->user_image = null;
            $user->save();
            // toast('profile Image deleted' ,'success');
            return back();
        }
    }
}
