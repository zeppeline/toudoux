@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My tasks</div>

                <div class="panel-body">
                    You are logged in!
                    <form action="/tasks" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset>
                            <ul>
                                @foreach($tasks as $task)
                                <li>
                                    <input type="hidden" name="{{ $task->id }}" value="0">
                                    <input type="checkbox" name="{{ $task->id }}" id="{{ $task->id }}" value="1" {{ $task->completed == 1 ? 'checked="checked"' : '' }}>
                                    <label for="{{ $task->id }}">{{ $task->body }}</label>
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
