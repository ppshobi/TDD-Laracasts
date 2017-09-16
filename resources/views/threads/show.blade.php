@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">{{ $thread->owner->name }} Posted:</a>                
                    {{ $thread->title }}
                </div>

                <div class="panel-body">
                   {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    @if(auth()->check())
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="{{ $thread->path() . '/replies' }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Say Something">
                        
                        </textarea>
                    </div>
                    <button class="btn btn-default" type="submit"> Post </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
