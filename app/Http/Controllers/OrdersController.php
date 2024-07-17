<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\User;
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
       public function store(Request $request)  
       {  
           $data = $request->validate([  
               'user_id' => 'required|exists:users,id',  
               'product_id' => 'required|exists:products,id',  
           ]);  
    
           $orderData['start'] = now();  
           $orderData['stop'] = now();
           $orderData['user_id'] = $data['user_id'];
           $orderData['product_id'] = $data['product_id'];  
           
           $user = User::find($data['user_id']);  
       
           if ($user) { 
               $order = orders::create($orderData);  
               return response()->json($order);  
           }  
       
           return response()->json(['error' => 'User not found'], 404);  
       }
       public function edit(Request $request,$id){
        $orders=orders::where('id',$id)->first()->update($request->toArray());
       }
       public function delete($id){
        $orders=orders::where('id',$id)->delete();
       }
}
