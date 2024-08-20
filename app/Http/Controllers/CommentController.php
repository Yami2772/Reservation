<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('User')) {
            $comment = Comment::create($request->merge(["status" => false])->toArray());
            return response()->json($comment);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function read($service_id = null)
    {
        if ($service_id) {
            $comments = Comment::where('service_id', $service_id)->get();
            if (!$comments) {
                return response()->json('inserted service_id does not exist!');
            }
        } else {
            $comments = Comment::orderby()->paginate(5);
        }
        return response()->json($comments);
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $comment = Comment::where('id', $id)->first();
            if ($comment) {
                $comment->delete();
            } else {
                return response()->json('Comment not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function CommentApproval(Request $request, $id)
    {
        $comment = Comment::where('id', $id)->first();
        if (!$comment) {
            return response()->json('Comment not found!');
        } else {
            $comment = $comment->update($request->merge([
                "score" => $comment['score'],
                "description" => $comment['descriptuon'],
                "user_id" => $comment['user_id'],
                "service_id" => $comment['service_id'],
                "status" => true,
            ]));
            return response()->json($comment);
        }
    }
}
