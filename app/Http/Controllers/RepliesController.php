<?php

namespace App\Http\Controllers;

use Gate;
use App\User;
use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use App\Notifications\YouWereMentioned;

/**
 * Class RepliesController
 * @package App\Http\Controllers
 */
class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(15);
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        try
        {
            if(Gate::denies('create', new Reply))
            {
                return response('You are posting too many times in a row :)', 422);
            }

            $this->validate(request(), ['body' => ['required', new SpamFree]]);

            $reply = $thread->addReply([
                'body'    => request('body'),
                'user_id' => auth()->id()
            ]);
        }
        catch (\Exception $e)
        {
            return response('Your Reply Could not be saved now', 422);
        }

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try
        {
            $this->validate(request(), ['body' => ['required', new SpamFree]]);

            $reply->update(request(['body']));
        }
        catch (\Exception $e)
        {
            return response('Sorry Your Reply Could Not be posted now',422);
        }

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }

}
