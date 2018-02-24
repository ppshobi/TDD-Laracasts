<?php

namespace App\Listeners;

use App\User;
use App\Notifications\YouWereMentioned;
use App\Events\ThreadRecievedNewReply;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function($user) use($event){
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
