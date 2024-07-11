<?php

namespace App\Http\Controllers;

use App\Models\setinge;
use Illuminate\Http\Request;

class SetingeController extends Controller
{
   public function index($id = null){
    if ($id) {
        $setinge = setinge::where('id', $id)->first();
    }
    else{
        $setinge = setinge::orderBy('id','desc')->paginate(5);
    }

    return response()->json($setinge);
   }
   public function store(Request $request){
    $setinge=setinge::create($request->toArray());
    return response()->json($setinge);
   }
   public function edit(Request $request,$id){
    $setinge=setinge::where('id',$id)->update($request->toArray());
   }
   public function delete($id){
    $setinge=setinge::where('id',$id)->delete();
   }
}
