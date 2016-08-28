<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;

class TaskController extends Controller
{
    public function view(Request $request)
    {
        $tasks = $this->index($request);
        return view('tasks')->with('tasks', $tasks);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        return $request->user()->tasks()->get();
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
            'body' => 'required|string',
        ]);

        $request->user()->tasks()->create([
            'body' => $request->body
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
        //
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
        //
    }

    /**
     * Updates all tasks at once
     */
    public function updateAll(Request $request)
    {
        foreach($request->all() as $key => $val) {
            Task::where('id', $key)->update(['completed' => $val]);

            // Check if a delete button has been clicked
            if(strpos($key, 'delete') !== false) {
                return $this->confirmDestroy(str_replace('delete-', '', $key));
            }
        }

        return redirect('/tasks');
    }

    /**
     * Add a confirm page to delete the tasks
     */
    public function confirmDestroy($id)
    {
        $task = Task::find($id);
        return view('confirmDestroy')->with('task', $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $taskId)
    {
        $task = Task::find($taskId);
        $this->authorize('destroy', $task);
        $task->delete();
        return redirect('/tasks');
    }
}
