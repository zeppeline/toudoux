<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;
use App\Project;
use App\Tag;
use App\User;
use Validator;

class ProjectController extends Controller
{

    /*
    ** Projects colors available
    */
    protected $colors = ['#ff77bd', // pink
                         '#736357', // gray
                         '#ffdd54', // yellow
                         '#6ed198', // green
                         '#74c2f7', // blue
                         '#fa7979' // red
                        ];

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
            'projectName' => 'required|string'
        ]);

        $request->user()->projects()->create([
            'name' => $request->projectName,
            'color' => $this->colors[array_rand($this->colors, 1)],
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
        $project = Project::find($id);
        return view('projectEdit')->with('project', $project);
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
            'projectName' => 'required|string'
        ]);

        if($validator->fails()) {
            return redirect('/api/projects/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $project = Project::find($id);
        $project->name = $request->input('projectName');
        $project->save();
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
        $project = Project::find($id);
        // $tasks = $project->tasks()->get();
        $this->authorize('destroy', $project);
        $project->delete();
        return redirect('/tasks');
    }

    /*
    ** Add the confirm delete page
    */
    public function confirmDelete($id)
    {
        $project = Project::find($id);
        $tasks = $project->tasks()->get();

        return view('projectDelete')->with(["tasks" => $tasks, "project" => $project]);
    }
}
