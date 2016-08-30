@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My tags</div>

                <div class="panel-body">
                    <form action="/api/tags/{{ $tag->id }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <fieldset>
                            <p>
                                Are you sure you want to delete this tag? It won't delete the tagged tasks
                            </p>
                            <p>
                                {{ $tag-> name }}
                            </p>
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
