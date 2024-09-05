<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $Page = Page::create($request->toArray());
            return response()->json($Page);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function read(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $Page = Page::where('id', $id);
            if (!$Page) {
                return response()->json('Page not found!');
            } else {
                $Page->update($request->toArray());
            }
            return response()->json($Page);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $Page = Page::where('id', $id)->first();
            if ($Page) {
                $Page->delete();
                return response()->json('Page deleted successfully!');
            } else {
                return response()->json('Page not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
