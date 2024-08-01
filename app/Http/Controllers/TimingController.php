<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimingRequest;
use App\Models\Service;
use App\Models\Timing;
use Illuminate\Http\Request;

class TimingController extends Controller
{
    public function create(Request $request)
    {
        $Timing = Timing::create($request->toArray());

        return response()->json($Timing);
    }
    public function read($id = null)
    {
        if ($id) {
            $Timing = Timing::where('id', $id)->first();
        } else {
            $Timing = Timing::paginate(5);
        }

        return response()->json($Timing);
    }
    public function getservice(TimingRequest $request)  
    {  
  
    
        // تبدیل ورودی‌ها به فرمت تاریخ و زمان  
        $start_time = $request->start_time; // فرض بر این است که فرمت درست است  
        $end_time = $request->end_time; // فرض بر این است که فرمت درست است  
    
        // بررسی وجود سرویس  
        $serviceAvailable = Timing::where('id', $request->service_id)  
            ->where('start_time', '<=', $start_time)  
            ->where('end_time', '>=', $end_time)  
            ->exists();  
    
        if (!$serviceAvailable) {  
            return response()->json(['success' => 'زمان در دسترس است']);  
        } else {  
            return response()->json(['errorMessage' => 'زمان قبلا رزرو شده است']);  
        }  
    }
}
