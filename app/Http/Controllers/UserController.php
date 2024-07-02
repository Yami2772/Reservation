<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id= null){
        $user= User::all();
        if($id) {
            $user=User::where('id',$id)->first();
        }
    
        return response()->json($user);
    }
    
    public function edit(Request $request, $id){
    $user=User::where('id',$id)->update($request->toArray());
    }
    public function delete($id){
    $user=User::where('id',$id)->delete();
    }
}
