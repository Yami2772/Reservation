<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function create(Request $request)
    {
        $Page = Page::create($request->toArray());

        return response()->json($Page);
    }
    public function read($id = null)
    {
        if ($id) {
            $Page = Page::where('id', $id)->first();
        } else {
            $Page = Page::paginate(5);
        }

        return response()->json($Page);
    }
    public function update(Request $request, $id)
    {
        $Page = Page::where('id', $id)->first();
        if (!$Page) {
            return response()->json('Page not found!');
        } else {
            $Page->update($request->toArray());
        }

        return response()->json($Page);
    }
    public function delete($id)
    {
        $Page = Page::where('id', $id)->first();
        if ($Page) {
            $Page->delete();
            return response()->json('Page deleted successfully!');
        } else {
            return response()->json('Page not found!');
        }
    }
}
