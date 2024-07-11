<?php

namespace App\Http\Controllers;

use App\Models\orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index($id = null){
        if ($id) {
            $orders = orders::where('id', $id)->first();
        }
        else{
            $orders = orders::orderBy('id','desc')->paginate(5);
        }
    
        return response()->json($orders);
       }
       public function store(Request $request){
        $data = $request->all();
        
        // یافتن کاربر مورد نظر بر اساس شناسه
        $user = orders::find($data['user_id']);
        
        // اضافه کردن اطلاعات مربوط به ساعت شروع و پایان از کاربر به سفارش
        $data['start'] = $user->start;
        $data['stop'] = $user->stop;
        
        $orders = orders::create($data); // ذخیره سفارش با اطلاعات مقداردهی شده
        return response()->json($orders);
    }
       public function edit(Request $request,$id){
        $orders=orders::where('id',$id)->first()->update($request->toArray());
       }
       public function delete($id){
        $orders=orders::where('id',$id)->delete();
       }
}
