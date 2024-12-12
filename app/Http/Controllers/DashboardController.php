<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use File, Hash, Auth;

class DashboardController extends Controller{
    /** dashboard */
    public function dashboard(Request $request){
        return view("backend.dashboard");
    }
    /** dashboard */

    /** profile */
    public function profile(Request $request){
        return view("backend.profile.profile");
    }
    /** profile */

    /** profile-profile */
    public function profileUpdate(Request $request){
        return view('backend.profile.update-profile');
    }
    /** profile-profile */

    /** update-profile */
    public function updateProfile(ProfileRequest $request){
        if($request->ajax()){ return true; }

        $id = $request->id;
        $exst_rec = User::where(['id' => $id])->first();

        $data = [
            'firstname' => ucfirst($request->firstname),
            'lastname' => ucfirst($request->lastname),
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id
        ];

        if(!empty($request->file('photo'))){
            $file = $request->file('photo');
            $filenameWithExtension = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = time()."_".$filename.'.'.$extension;

            $folder_to_upload = public_path().'/uploads/users/';

            if(!File::exists($folder_to_upload))
                File::makeDirectory($folder_to_upload, 0777, true, true);

            $data['photo'] = $filenameToStore;
        }else{
            $data['photo'] = $exst_rec->photo;
        }

        $update = User::where(['id' => $id])->update($data);

        if ($update) {
            if (!empty($request->file('photo'))) {
                $file->move($folder_to_upload, $filenameToStore);

                $file_path = public_path().'/uploads/users/'.$exst_rec->photo;

                if(File::exists($file_path) && $file_path != ''){
                    if($exst_rec->photo != 'profile-pic.png'){
                        @unlink($file_path);
                    }
                }
            }

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile.')->withInput();
        }
    }
    /** update-profile */

    /** change-password */
    public function changePassword(Request $request){
        return view("backend.profile.change-password");
    }
    /** change-password */

    /** password-change */
    public function passwordChange(ChangePasswordRequest $request){
        if($request->ajax()){ return true; }

        if(Hash::check($request->currentPassword, Auth::user()->password)) {
            if($request->newPassword != $request->confirmPassword){
                return redirect()->back()->with('error', 'Confirm Password must be same as new password.');
            }

            $user = User::where(['id' => Auth::user()->id])->update(['password' => Hash::make($request->newPassword)]);

            if($user){
                    return redirect()->back()->with('success', 'Password updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update password.');
            }
        }else{
            return redirect()->back()->with('error', 'Mismatch current password.');
        }
    }
    /** password-change */
}
