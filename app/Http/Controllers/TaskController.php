<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
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
            'dueDate' => 'required|date'
        ]);

        $request->user()->tasks()->create([
            'body' => $request->body,
            'due_date' => $request->dueDate
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
        $task = Task::find($id);
        return view('taskEdit')->with('task', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $taskId)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string'
        ]);

        if($validator->fails()) {
            return redirect('/api/tasks/' . $taskId . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $task = Task::find($taskId);
        $task->body = $request->input('body');
        $task->save();
        return redirect('/tasks');
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

            // Check if an edit button has been clicked
            if(strpos($key, 'edit') !== false) {
                return $this->edit(str_replace('edit-', '', $key));
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
