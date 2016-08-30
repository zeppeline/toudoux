@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit a tag</div>

                <div class="panel-body">
                    <form action="/api/tags/{{ $tag->id }}" method="post" class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <fieldset class="form-group">
                            <label for="tagName">Edit tag name:</label>
                            <input class="form-control" type="text" name="tagName" value="{{ $tag->name }}" id="tagName">
                            @if ($errors->has('tagName'))
                                <div>
                                    <?php echo $errors->first('tagName'); ?>
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
