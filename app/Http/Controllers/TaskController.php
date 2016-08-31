<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests;
use App\Task;
use App\Project;
use App\Tag;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function view(Request $request)
    {
        $data = $this->index($request);
        return view('tasks')->with(['tasks' => $data['tasks'], 'projects' => $data['projects'], 'tags' => $data['tags']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $projects = $request->user()->projects()->get();
        $tasks = $request->user()->tasks()->orderBy('created_at', 'desc')->get();
        $tags = $request->user()->tags()->get();

        if((( ! isset($request->minDate) || $request->minDate === '' ) ||
           ( ! isset($request->maxDate) || $request->maxDate === '')) &&
           ( ! isset($request->project) || $request->project === '') &&
           ( ! isset($request->tags) || $request->tags === '' )) {
            return ["tasks" => $tasks, "projects" => $projects, "tags" => $tags];
        }

        /*
        ** Sort tasks by project
        */
        if(isset($request->project) && $request->project != '') {
            $tasks = Project::find($request->project)->tasks()->get();
        }

        /*
        ** Sort by tag
        */
        if(isset($request->tags)) {
            $tasksToShow = [];

            foreach($request->tags as $tag) {
                foreach($tasks as $task) {
                    if($task->tags->contains($tag)) {
                        $tasksToShow[] = $task;
                    }
                }
            }

            $tasks = $tasksToShow;
        }

        /*
        ** Sort tasks by date
        */
        if(isset($request->minDate) && isset($request->maxDate)) {
            $minDate = Carbon::parse($request->minDate);
            $maxDate = Carbon::parse($request->maxDate);
            $tasksToShow = [];

            foreach($tasks as $task) {
                if(Carbon::parse($task->due_date)->between($minDate, $maxDate)) {
                    $tasksToShow[] = $task;
                }
            }

            $tasks = $tasksToShow;
        }

        return ["tasks" => $tasks, "projects" => $projects, "tags" => $tags];
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
            'dueDate' => 'date'
        ]);

        $task = $request->user()->tasks()->create([
            'body' => $request->body,
            'due_date' => $request->dueDate,
            'project_id' => $request->project
        ]);

        if(isset($request->tags)) {
            $tags = [];

            foreach($request->tags as $tag) {
                $tags[] = $tag;
            }

            $task->tags()->attach($tags);
        }

        return [$task, $task->project, $task->tags];
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
        $projects = Auth::user()->projects()->get();
        $tags = Auth::user()->tags()->get();
        return view('taskEdit')->with(['task' => $task, 'tags' => $tags, 'projects' => $projects]);
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
            'body' => 'required|string',
            'dueDate' => 'date'

        ]);

        if($validator->fails()) {
            return redirect('/api/tasks/' . $taskId . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $task = Task::find($taskId);
        $task->update($request->all());

        if(isset($request->tags)) {
            $tags = [];

            foreach($request->tags as $tag) {
                $tags[] = $tag;
            }

            $task->tags()->sync($tags);
        }

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
        return view('taskDelete')->with('task', $task);
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
