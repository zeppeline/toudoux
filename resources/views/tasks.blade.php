@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Mes tâches</div>

                <div class="panel-body">
                    You are logged in!
                    <form>
                        <fieldset>
                            <ul>
                                @foreach($tasks as $task)
                                <li>
                                    <input type="checkbox" name="{{ $task->id }}" id="{{ $task->id }}" value="" {{ $task->completed == 1 ? 'checked="checked"' : '' }}>
                                    <label for="{{ $task->id }}">{{ $task->body }}</label>
                                </li>
                                @endforeach
                            </ul>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
