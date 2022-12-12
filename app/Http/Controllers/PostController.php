<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $startTime = microtime(true);
        $posts = Post::where('user_id', Auth()->user()->id)->get();
        $endTime = microtime(true);
        return response()->json(['status' => true, 'posts' => $posts, 'time' => $startTime - $endTime], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:posts,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $startTime = microtime(true);
        $data = Post::create(['name' => $request->name, 'user_id' => Auth()->user()->id]);
        $endTime = microtime(true);
        return response()->json(['status' => true, 'data' => $data, 'time' => $startTime - $endTime], 200);
    }

    public function destroy($id)
    {
        $startTime = microtime(true);
        Post::find($id)->delete();
        $endTime = microtime(true);

        return response()->json(['status' => true, 'time' => $startTime - $endTime], 200);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:posts,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $startTime = microtime(true);
        $data = Post::find($id)->update(['name' => $request['name']]);
        $endTime = microtime(true);

        return response()->json(['status' => true, 'time' => $startTime - $endTime, 'data' => $data], 200);
    }
}