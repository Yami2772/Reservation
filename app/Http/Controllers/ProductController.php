<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id = null){
        if ($id) {
            $product = product::where('id', $id)->first();
        }
        else{
            $product = product::orderBy('id','desc')->paginate(5);
        }
    
        return response()->json($product);
       }
       public function store(Request $request){
        $product=product::create($request->toArray());
        return response()->json($product);
       }
       public function edit(Request $request,$id){
        $product=product::where('id',$id)->first()->update($request->toArray());
       }
       public function delete($id){
        $product=product::where('id',$id)->delete();
       }
}
