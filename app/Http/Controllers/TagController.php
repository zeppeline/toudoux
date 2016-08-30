<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Tag;
use App\Task;
use App\Project;
use Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required|string'
        ]);

        $request->user()->tags()->create([
            'name' => $request->tagName,
            'user_id' => $request->user()->id
        ]);

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tagEdit')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tagName' => 'required|string'
        ]);

        if($validator->fails()) {
            return redirect('/api/tags/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $tag = Tag::find($id);
        $tag->name = $request->input('tagName');
        $tag->save();

        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $this->authorize('destroy', $tag);
        $tag->delete();
        return redirect('/tasks');
    }

    /*
    ** Add the confirm delete page
    */
    public function confirmDelete($id)
    {
        $tag = Tag::find($id);

        return view('tagDelete')->with("tag", $tag);
    }
}
