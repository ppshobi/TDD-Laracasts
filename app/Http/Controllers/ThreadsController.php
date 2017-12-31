<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Inspections\Spam;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

/**
 * Class ThreadsController
 * @package App\Http\Controllers
 */
class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return ThreadsController|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|\Illuminate\Http\Response|\Illuminate\Support\Collection
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);
        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $spam->detect(request('body'));

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your Thread Has been Published');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Channel $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     * @internal param $channelId
     */
    public function show (Channel $channel, Thread $thread)
    {
        if(auth()->check())
        {
            auth()->user()->read($thread);
        }

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy (Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|static
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        }

        $threads = $threads->get();
        return $threads;
    }
}
