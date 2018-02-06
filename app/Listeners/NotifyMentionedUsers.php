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
        collect($event->reply->mentionedUsers())
        ->map(function($name){
            return User::whereName($name)->first();
        })
        ->filter()
        ->each(function($user) use($event){
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
