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
                    <form class="row no-js" action="/api/projects" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group col-md-4">
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
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="/tasks">All</a>
                        </li>
                        @foreach($projects as $project)
                            <li class="list-group-item">
                                <a class="btn btn-default" href="/projects/{{ $project->id }}/confirmdelete">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                                <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; background-color: {{ $project->color }}; margin-right: 10px; vertical-align: middle;"></span>
                                <a href="?project={{ $project->id }}">{{ $project->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">My tasks</h3>
                    <ul class="nav nav-pills">
                        <li><a href="/tasks">All</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addDay()->toDateString() }}">Today</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addWeek()->toDateString() }}">Next 7 days</a></li>
                        <li><a href="?minDate={{ \Carbon\Carbon::today()->toDateString() }}&amp;maxDate={{ \Carbon\Carbon::today()->addMonth()->toDateString() }}">Within one month</a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    <form class="row no-js" action="/api/tasks" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group col-md-4">
                                <label for="newTask">New task:</label>
                                <input class="form-control" type="text" name="body" value="" id="newTask">
                                @if ($errors->has('body'))
                                    <div>
                                        <?php echo $errors->first('body'); ?>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="dueDate">Add due date (yyyy-mm-dd):</label>
                                <input class="form-control" type="text" name="dueDate" id="dueDate">
                                @if ($errors->has('dueDate'))
                                    <div>
                                        <?php echo $errors->first('dueDate'); ?>
                                    </div>
                                @endif
                            </div>
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
                            <div class="form-group col-md-12">
                                <input class="btn btn-primary" type="submit" value="Add new task">
                            </div>
                        </fieldset>
                    </form>

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
                                        <label for="{{ $task->id }}"><input type="checkbox" name="{{ $task->id }}" id="{{ $task->id }}" value="1" {{ $task->completed == 1 ? 'checked="checked"' : '' }}>{{ $task->body }} (due {{ $task->due_date->diffForHumans() }})</label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </fieldset>
                        <input class="btn btn-primary" type="submit" value="Save changes">
                    </form>
                    <tasks list="{{ json_encode($tasks) }}"></tasks>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
