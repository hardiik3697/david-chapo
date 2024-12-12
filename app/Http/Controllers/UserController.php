<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\DataTables;
use DB, File;

class UserController extends Controller{
    /** index */
        public function index(Request $request){
            if ($request->ajax()) {
                $data = User::orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<div class="btn-group">
                                    <a href="'.route('user.read', ['id' => base64_encode($data->id)]) . '" class="btn btn-sm rounded-pill btn-icon">
                                        <i class="ri-eye-line"></i>
                                    </a> &nbsp;
                                    <a href="'.route('user.update', ['id' => base64_encode($data->id)]).'" class="btn btn-sm rounded-pill btn-icon">
                                        <i class="ri-edit-box-line"></i>
                                    </a> &nbsp;
                                    <a href="javascript:;" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-line"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                        <li><a href="javascript:;" class="dropdown-item" onclick="status(this);" data-status="active" data-id="'.base64_encode($data->id).'">Active</a></li>
                                        <li><a href="javascript:;" class="dropdown-item" onclick="status(this);" data-status="inactive" data-id="'.base64_encode($data->id).'">Inactive</a></li>
                                        <li><a href="javascript:;" class="dropdown-item" onclick="status(this);" data-status="deleted" data-id="'.base64_encode($data->id).'">Delete</a></li>
                                    </ul>
                                </div>';
                    })

                    ->editColumn('status', function ($data) {
                        if ($data->status == 'active') {
                            return '<span class="badge badge-pill badge-success">Active</span>';
                        } else if ($data->status == 'inactive') {
                            return '<span class="badge badge-pill badge-warning">Inactive</span>';
                        } else if ($data->status == 'deleted') {
                            return '<span class="badge badge-pill badge-danger">Deleted</span>';
                        } else {
                            return '-';
                        }
                    })

                    ->editColumn('profile', function ($data) {
                        $image = '<img src="'.URL('/uploads/users/profile-pic.png').'" alt="profile-pic" class="rounded-circle" width="45" height="45">';

                        if($data->photo != '' || $data->photo != null)
                            $image =  '<img src="'.URL('/uploads/users/')."/".$data->photo.'" alt="profile-pic" class="rounded-circle" width="45" height="45">';

                        return $image;
                    })

                    ->editColumn('name', function ($data) {
                        return '<span>'.$data->firstname.' '.$data->lastname.'</span>';
                    })

                    ->rawColumns(['profile', 'name', 'action', 'status'])
                    ->make(true);
            }

            return view('backend.user.index');
        }
    /** index */

    /** create */
        public function create(Request $request){
            return view('backend.user.create');
        }
    /** create */

    /** insert */
        public function insert(UserRequest $request){
            if($request->ajax()){ return true; }
            $password = 'Abcd1234?';

            if($request->password != '' && $request->password != NULL)
                $password = $request->password;

            $data = [
                'firstname' => ucfirst($request->firstname),
                'lastname' => ucfirst($request->lastname),
                'username' => $request->username ?? '',
                'email' => $request->email,
                'phone' => $request->phone ?? '',
                'status' => 'active',
                'password' => bcrypt($password),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id,
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
                $data['photo'] = 'profile-pic.png';
            }

            DB::beginTransaction();
            try {
                $user = User::create($data);

                if($user){
                    if (!empty($request->file('photo')))
                        $file->move($folder_to_upload, $filenameToStore);

                    DB::commit();
                    return redirect()->route('user')->with('success', 'Record inserted successfully');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to insert record')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
            }
        }
    /** insert */

    /** update */
        public function update(Request $request, $id = ''){
            if (isset($id) && $id != '' && $id != null)
                $id = base64_decode($id);
            else
                return redirect()->route('user')->with('error', 'Something went wrong');

            $path = URL('/uploads/users').'/';
            $data = User::select('id', 'firstname', 'lastname', 'username', 'email', 'phone', 'password',
                                    DB::Raw("CASE
                                        WHEN ".'photo'." != '' THEN CONCAT("."'".$path."'".", ".'photo'.")
                                        ELSE CONCAT("."'".$path."'".", 'profile-pic.png')
                                    END as photo")
                                )
                            ->where(['id' => $id])
                            ->first();

            return view('backend.user.update')->with(['data' => $data]);
        }
    /** update */

    /** alter */
        public function alter(UserRequest $request){
            if($request->ajax()) { return true; }

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

            if($request->password != '' && $request->password != NULL)
                $data['password'] = bcrypt($request->password);

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

            DB::beginTransaction();
            try {
                $update = User::where(['id' => $id])->update($data);

                if ($update) {
                    if(!empty($request->file('photo'))){
                        $file->move($folder_to_upload, $filenameToStore);

                        $file_path = public_path().'/uploads/users/'.$exst_rec->photo;

                        if(File::exists($file_path) && $file_path != ''){
                            if($exst_rec->photo != 'profile-pic.png'){
                                @unlink($file_path);
                            }
                        }
                    }

                    DB::commit();
                    return redirect()->route('user')->with('success', 'Record updated successfully');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to update record')->withInput();
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with('error', 'Something went wrong, please try again later')->withInput();
            }
        }
    /** alter */

    /** read */
        public function read(Request $request, $id = ''){
            if (isset($id) && $id != '' && $id != null)
                $id = base64_decode($id);
            else
                return redirect()->route('user')->with('error', 'Something went wrong');

            $path = URL('/uploads/users').'/';
            $data = User::select( 'id', 'firstname', 'lastname', 'username', 'email', 'phone', 'password', 'status',
                                    DB::Raw("CASE
                                        WHEN ".'photo'." != '' THEN CONCAT("."'".$path."'".", ".'photo'.")
                                        ELSE CONCAT("."'".$path."'".", 'profile-pic.png')
                                    END as photo")
                                )
                                ->where(['id' => $id])
                                ->first();

            return view('backend.user.read')->with(['data' => $data]);
        }
    /** read */

    /** status */
        public function status(Request $request){
            if (!$request->ajax()) { exit('No direct script access allowed'); }

            if (!empty($request->all())) {
                $id = base64_decode($request->id);
                $status = $request->status;

                $data = User::where(['id' => $id])->first();

                if(!empty($data)){
                    $process = User::where(['id' => $id])->update(['status' => $status, 'updated_by' => auth()->user()->id]);

                    if($process)
                        return response()->json(['code' => 200]);
                    else
                        return response()->json(['code' => 201]);
                } else {
                    return response()->json(['code' => 201]);
                }
            } else {
                return response()->json(['code' => 201]);
            }
        }
    /** status */
}
