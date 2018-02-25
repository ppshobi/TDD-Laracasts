@extends('layouts.app')

@section('header')
    <link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="level">
                            <span class="flex">
                                <div class="panel-heading">
                                    <img src="{{ asset('storage/'. $thread->owner->avatar()) }}" width="50" height="50"
                                         alt="" class="mr-1">
                                    <a href="{{ route('profile', $thread->owner->name)}}">{{ $thread->owner->name }} Posted:</a>
                                    {{ $thread->title }}
                                </div>
                            </span>
                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                            @endcan
                        </div>

                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>This Thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#"> {{ $thread->owner->name }} </a> and currently
                                has <span v-text="repliesCount"></span>
                                {{ str_plural('reply', $thread->replies_count) }}
                            </p>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
