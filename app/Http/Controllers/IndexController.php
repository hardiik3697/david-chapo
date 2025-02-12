<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\Link;
use DateTime;

class IndexController extends Controller
{
    /** 
     * index view
     */
    public function index(Request $request){
        $platform = Platform::select(['id', 'name', 'description', 'frontend_url', 'backend_url', 'logo', 'image'])->where(['status' => 'active'])->get()->toArray();
        return view('index')->with(['platform' => $platform]);
    }

    /**
     * Platform 
     */
    public function platform(Request $request, $id = null){
        $id = base64_decode($id);

        if(empty($id) && $id == null){
            return redirect()->back()->with(['error' => 'Something went wrong']);
        }

        $data = Platform::select('id', 'name', 'description', 'frontend_url', 'backend_url', 'logo', 'image')->where(['id' => $id])->first();
            
        if(!empty($data)){
            return view('frontend.platform')->with(['data' => $data]);
        }else{
            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Get Hashcode from url and sent to payment page
     */
    public function link(Request $request, $key = null){
        if($key == null){
            return redirect()->route('index')->with(['error' => 'Something went wrong']);
        }

        $date = new DateTime;
        $date->modify('-10 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $check = Link::select('id')->where(['link' => $key])->where('created_at', '>=', $formatted_date)->first();

        if(!empty($check)){
            Link::where(['link' => $key])->delete();
            session(['link' => $key]);
            return redirect()->route('payment.charge');
        }else{
            return redirect()->route('index')->with(['error' => 'Something went wrong']);
        }
    }
}
