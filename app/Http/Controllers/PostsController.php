<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'success'   => true,
            'messages'  => 'Daftar semua post',
            'data'      => $posts
        ], 200);
    } 

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Semua kolom wajib diisi',
                'data' => $validator->errors(),
            ], 401);
        } else 
        {
            $post = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),        
            ]);

            if($post) 
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Post berhasil disimpan',
                    'data' => $post
                ], 201);
            } else 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Post gagal disimpan',
                ], 400);
            }
        }
    }

    public function show($id)
    {
        $post = Post::find($id);

        if($post)
        {
            return response()->json([
                'success' => true,
                'message' => 'Detail post',
                'data'    => $post
            ], 200);
        } else
        {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]); 

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => 'Semua kolom wajib diisi',
                'data' => $validator->errors()
            ], 401);
        } else
        {
            $post = Post::whereId($id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);
    
            if($post)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Post berhasil diupdate',
                    'data' => $post
                ], 201);
            } else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Post gagal diupdate'
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->first();
        $post->delete();

        if($post)
        {
            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dihapus'
            ], 200);
        }
    }
}
