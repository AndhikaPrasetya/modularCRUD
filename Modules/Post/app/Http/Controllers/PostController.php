<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Post::query();
            if($search= $request->input('search.value')){
                $data->where(function($data) use ($search){
                    $data->where('title','like',"%{$search}%")
                    ->orWhere('content','like',"%{$search}%");
                });
            }
        
        return Datatables::eloquent($data)
        ->addIndexColumn()
        ->addColumn('title', function($data){
            return $data->title;
        })
        ->addColumn('content', function($data){
            return $data->content;
        })
        ->addColumn('action', function ($data) {
            return
                '<div class="d-flex gap-3">' .
                '<a href="' . route('post.edit', $data->id) . '" class="btn btn-outline-info btn-sm"> <i class="icon-pencil"></i> <span>Edit</span></a>' .
                '<button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="' . $data->id . '" data-section="post">' .
                '<i class="fa fa-trash-o"></i> Delete</button>' .
                '</div>';
        })
        ->rawColumns([ 'action'])
        ->make(true);
        }
        return view('post::index');

    }

        // $posts = Post::all();
        // return view('post::index', compact('posts'));
    

  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('post.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('post::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Post::find($id);
        return view('post::edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post =Post::find($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            ]);

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Data berhasil dihapus!');
    }
}
