<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(CreateCommentRequest $request)
    {
        if ($request->user()->hasRole(['Admin', 'User'])) {
            $duplicate = Comment::where('user_id', $request->user()->id)
                ->where('service_id', $request->service_id)
                ->exists();
            if (!$duplicate) {
                $comment = Comment::create($request->merge(["status" => "neutral"])->toArray());
                return response()->json($comment);
            } else {
                return response()->json('U have a set comment for this service_id', 403);
            }
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function readForUsers($service_id)
    {
        $comments = Comment::where('service_id', $service_id)->orderBy('id', 'desc')->paginate(10);
        return response()->json($comments);
    }

    public function readForAdmin(Request $request, $service_id = null)
    {
        if ($request->user()->hasRole('Admin')) {
            if ($service_id) {
                $comments = Comment::where('service_id', $service_id)->orderBy('id', 'desc')->paginate(10);
                if (!$comments) {
                    return response()->json('inserted service_id does not exist!');
                }
            } else {
                $comments = Comment::orderBy('id', 'desc')->paginate(10);
            }
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
        return response()->json($comments);
    }

    public function delete(DeleteRequest $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $comment = Comment::where('id', $request->id)->first();
            if ($comment) {
                $comment->delete();
            } else {
                return response()->json('Comment not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function CommentApproval(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $comment = Comment::where('id', $id)->first();
            if (!$comment) {
                return response()->json('Comment not found!');
            } else {
                $comment = $comment->update($request->merge([
                    "score" => $comment['score'],
                    "description" => $comment['descriptuon'],
                    "user_id" => $comment['user_id'],
                    "service_id" => $comment['service_id'],
                    "status" => "accepted",
                ]));
                return response()->json($comment);
            }
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function CommentDeclining(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $comment = Comment::where('id', $id)->first();
            if (!$comment) {
                return response()->json('Comment not found!');
            } else {
                $comment = $comment->update($request->merge([
                    "score" => $comment['score'],
                    "description" => $comment['descriptuon'],
                    "user_id" => $comment['user_id'],
                    "service_id" => $comment['service_id'],
                    "status" => "declined",
                ]));
                return response()->json($comment);
            }
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }
}
