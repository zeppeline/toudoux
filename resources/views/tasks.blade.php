@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">My projects</h3>
                </div>
                <div class="panel-body">
                    <!-- New project form -->
                    <form class="row no-js" action="/api/projects" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group col-md-12">
                                <label for="newProject">New project:</label>
                                <input class="form-control" type="text" name="projectName" value="" id="newProject">
                                @if ($errors->has('projectName'))
                                    <div>
                                        <?php echo $errors->first('projectName'); ?>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <input class="btn btn-primary" type="submit" value="Add new project">
                            </div>
                        </fieldset>
                    </form>
                    <!-- Projects list -->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="/tasks">All</a>
                        </li>
                        @foreach($projects as $project)
                            <li class="list-group-item">
                                <a class="btn btn-default" href="/projects/{{ $project->id }}/confirmdelete">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                                <a class="btn btn-default" href="/api/projects/{{ $project->id }}/edit">
                                    edit
                                </a>
                                <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; background-color: {{ $project->color }}; margin-right: 10px; vertical-align: middle;"></span>
                                <a href="?project={{ $project->id }}">{{ $project->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    My tags
                </div>
                <div class="panel-body">
                    <!-- New tag form -->
                    <form class="row no-js" action="/api/tags" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group col-md-12">
                                <label for="tagName">New tag:</label>
                                <input class="form-control" type="text" name="tagName" value="" id="tagName">
                                @if ($errors->has('tagName'))
                                    <div>
                                        <?php echo $errors->first('tagName'); ?>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <input class="btn btn-primary" type="submit" value="Add new tag">
                            </div>
                        </fieldset>
                    </form>
                    <!-- Tags list -->
                    <form class="" action="/tasks" method="get">
                        <div>
                            <ul class="list-group">
                                @foreach($tags as $tag)
                                <li class="list-group-item row">
                                    <a class="btn btn-default" href="/tags/{{ $tag->id }}/confirmdelete">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a class="btn btn-default" href="/api/tags/{{ $tag->id }}/edit">
                                        edit
                                    </a>
                                    <div class="checkbox">
                                        <label for="tag{{ $tag->id }}">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                                <input type="submit" value="Sort tags" class="btn btn-primary">
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">My tasks</h3>
                    <!-- Sort by date -->
                    <ul class="nav nav-pills">
                        <li><a href="/tasks">All</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addDay()->toDateString() }}">Today</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addWeek()->toDateString() }}">Next 7 days</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addMonth()->toDateString() }}">Within one month</a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    <!-- New task form -->
                    <form class="row no-js" action="/api/tasks" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group col-md-4">
                                <!-- Add task name (mandority) -->
                                <label for="newTask">New task:</label>
                                <input class="form-control" type="text" name="body" value="" id="newTask">
                                @if ($errors->has('body'))
                                    <div>
                                        <?php echo $errors->first('body'); ?>
                                    </div>
                                @endif
                            </div>
                            <!-- Add due date (non mandatory) -->
                            <div class="form-group col-md-4">
                                <label for="dueDate">Add due date (yyyy-mm-dd):</label>
                                <input class="form-control" type="text" name="dueDate" id="dueDate">
                                @if ($errors->has('dueDate'))
                                    <div>
                                        <?php echo $errors->first('dueDate'); ?>
                                    </div>
                                @endif
                            </div>
                            <!-- Add project (non mandatory) -->
                            <div class="form-group col-md-4">
                                <label for="project">Assign project:</label>
                                <select class="form-control" id="project" name="project">
                                    <option value="">(None)</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Add tags (non mandatory) -->
                            <div class="form-group col-md-12">
                                <label class="col-md-12">Add tag(s):</label>
                                @foreach($tags as $tag)
                                    <label for="newtag{{ $tag->id }}">
                                        <input type="checkbox" name="tags[]" id="newtag{{ $tag->id }}" value="{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>
                                @endforeach
                            </div>
                            <div class="form-group col-md-12">
                                <input class="btn btn-primary" type="submit" value="Add new task">
                            </div>
                        </fieldset>
                    </form>
                    <!-- Tasks list -->
                    <form class="no-js" action="/tasks" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset>
                            <ul class="list-group">
                                @foreach($tasks as $task)
                                    <li class="form-group list-group-item row">
                                        <input type="hidden" name="{{ $task->id }}" value="0">
                                        <div class="col-md-3">
                                            <button class="btn btn-default" type="submit" name="{{ 'delete-' . $task->id }}">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <input class="btn btn-default" type="submit" name="{{ 'edit-' . $task->id }}" value="edit">
                                        </div>
                                        <div class="checkbox col-md-9">
                                            <label for="{{ $task->id }}"><input type="checkbox" name="{{ $task->id }}" id="{{ $task->id }}" value="1" {{ $task->completed == 1 ? 'checked="checked"' : '' }}>{{ $task->body }} {{ $task->due_date ? '(due ' . $task->due_date->diffForHumans() . ')' : '' }}</label>
                                            <!-- Display tags -->
                                            <p>
                                                @foreach($task->tags as $tag)
                                                    <a href="/tasks?tags[]={{ $tag->id }}">#{{ $tag->name }}</a>
                                                @endforeach
                                            </p>
                                            <!-- Display project -->
                                            @if($task->project()->first())
                                                <p>
                                                    <?php $project = $task->project()->first(); ?>
                                                    <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; background-color: {{ $project->color }}; margin-right: 10px; vertical-align: middle;"></span>
                                                    <a href="?project={{ $task->project_id }}">{{ $project->name }}</a>
                                                </p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </fieldset>
                        <input class="btn btn-primary" type="submit" value="Save changes">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
