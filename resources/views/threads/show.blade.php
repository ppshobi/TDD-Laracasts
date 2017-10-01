@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="level">
                    <span class="flex">
                        <div class="panel-heading">
                            <a href="{{ route('profile', $thread->owner->name)}}">{{ $thread->owner->name }} Posted:</a>
                            {{ $thread->title }}
                        </div>
                    </span>
                    <form action="{{ $thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-link">Delete Thread</button>
                    </form>
                </div>

                <div class="panel-body">
                   {{ $thread->body }}
                </div>
            </div>
            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach
            {{ $replies->links() }}
            @if(auth()->check())
                <form action="{{ $thread->path() . '/replies' }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                <textarea name="body" id="body" rows="5" class="form-control" placeholder="Say Something">

                </textarea>
                    </div>
                    <button class="btn btn-default" type="submit"> Post </button>
                </form>
            @else
                <p class="text-center"><a href="{{ route('login') }}">Sign in</a> to post Comments </p
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>This Thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#"> {{ $thread->owner->name }} </a> and currently has {{ $thread->replies_count }}
                        {{ str_plural('reply', $thread->replies_count) }}
                    </p>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
