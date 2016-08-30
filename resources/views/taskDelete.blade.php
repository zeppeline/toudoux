@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My tasks</div>

                <div class="panel-body">
                    <form action="/api/tasks/{{ $task->id }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <fieldset>
                            <p>
                                Are you sure you want to delete this task?
                            </p>
                            <p>
                                {{ $task->body }}
                            </p>
                            <input type="submit" value="Yessir!">
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
