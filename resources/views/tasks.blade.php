@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My tasks</div>

                <div class="panel-body">
                    <form action="/api/tasks" method="post">
                        {{ csrf_field() }}
                        <fieldset>
                            <label for="newTask">New task:</label>
                            <input type="text" name="body" value="" id="newTask">
                            @if ($errors->has('body'))
                                <div>
                                    <?php echo $errors->first('body'); ?>
                                </div>
                            @endif
                            <br>
                            <label for="dueDate">Add due date (yyyy-mm-dd):</label>
                            <input type="text" name="dueDate" id="dueDate">
                            @if ($errors->has('dueDate'))
                                <div>
                                    <?php echo $errors->first('dueDate'); ?>
                                </div>
                            @endif
                            <br>
                            <input type="submit" value="Add new task">
                        </fieldset>
                    </form>

                    <form action="/tasks" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset>
                            <ul>
                                @foreach($tasks as $task)
                                <li>
                                    <input type="hidden" name="{{ $task->id }}" value="0">
                                    <input type="submit" name="{{ 'delete-' . $task->id }}" value="x">
                                    <input type="submit" name="{{ 'edit-' . $task->id }}" value="edit">
                                    <input type="checkbox" name="{{ $task->id }}" id="{{ $task->id }}" value="1" {{ $task->completed == 1 ? 'checked="checked"' : '' }}>
                                    <label for="{{ $task->id }}">{{ $task->body }} (due {{ $task->due_date->diffForHumans() }})</label>
                                </li>
                                @endforeach
                            </ul>
                        </fieldset>
                        <input type="submit" value="Save changes">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
