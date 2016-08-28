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
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset>
                            <label for="body">Edit task:</label>
                            <input type="text" name="body" value="{{ $task->body }}" id="body">
                            @if ($errors->has('body'))
                                <div>
                                    <?php echo $errors->first('body'); ?>
                                </div>
                            @endif
                            <input type="submit" value="Edit">
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
