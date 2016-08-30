@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My project names</div>

                <div class="panel-body">
                    <form action="/api/projects/{{ $project->id }}" method="post" class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset class="form-group">
                            <label for="projectName">Edit project name:</label>
                            <input class="form-control" type="text" name="projectName" value="{{ $project->name }}" id="projectName">
                            @if ($errors->has('projectName'))
                                <div>
                                    <?php echo $errors->first('projectName'); ?>
                                </div>
                            @endif
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
