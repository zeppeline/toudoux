@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My projects</div>

                <div class="panel-body">
                    <form action="/api/projects/{{ $project->id }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <fieldset>
                            @if(count($tasks) == 0)
                                <p>
                                    Are you sure you want to delete this project? Since it doesn't contain any task, none will be deleted in the process.
                                </p>
                            @else
                                <p>
                                    Are you sure you want to delete this project? It will delete the following tasks
                                </p>
                                <ul class="list-group">
                                    <li class="list-group-item disabled">{{ $project->name }}</li>
                                    @foreach($tasks as $task)
                                        <li class="list-group-item">{{ $task->body }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <input class="btn btn-danger" type="submit" value="Yessir!">
                            <a href="/tasks" class="btn btn-default">Cancel</a>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
