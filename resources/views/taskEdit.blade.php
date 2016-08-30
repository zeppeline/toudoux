@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit task</div>

                <div class="panel-body">
                    <form action="/api/tasks/{{ $task->id }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset>
                            <div class="form-group col-md-12">
                                <label for="body">Edit task name:</label>
                                <input type="text" name="body" value="{{ $task->body }}" id="body" class="form-control">
                                @if ($errors->has('body'))
                                <div>
                                    <?php echo $errors->first('body'); ?>
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="dueDate">Add due date (yyyy-mm-dd):</label>
                                <input class="form-control" type="text" name="dueDate" id="dueDate" value="{{ $task->dueDate->toDateString() }}">
                                @if ($errors->has('dueDate'))
                                    <div>
                                        <?php echo $errors->first('dueDate'); ?>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="project">Assign project:</label>
                                <select class="form-control" id="project" name="project">
                                    <option value="">(None)</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ isset($task->project->id) && $task->project->id === $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-12">Add tag(s):</label>
                                @foreach($tags as $tag)
                                    <label for="tag{{ $tag->id }}">
                                        <input type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}" {{ $task->tags->contains($tag->id) ? 'checked' : '' }} >
                                        {{ $tag->name }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                        <input type="submit" value="Edit" class="btn btn-primary">
                        <a href="/tasks" class="btn btn-default">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
