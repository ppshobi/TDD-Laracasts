@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @forelse($threads as $thread)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <h4 class="flex">
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            </h4>
                            <strong>
                                <a href="{{ $thread->path() }}">
                                    {{ $thread->replies_count }} {{ str_plural('Reply', $thread->replies_count) }}
                                </a>
                            </strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="body"> {{ $thread->body }} </div>
                    </div>
                </div>
            @empty
                <p>There is no threads in this channel</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
