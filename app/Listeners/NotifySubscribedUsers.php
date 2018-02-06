<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadRecievedNewReply;

class NotifySubscribedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)->each
            ->notify($event->reply);
    }
}
