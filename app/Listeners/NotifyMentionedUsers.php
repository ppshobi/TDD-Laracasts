<?php

namespace App\Listeners;

use App\User;
use App\Notifications\YouWereMentioned;
use App\Events\ThreadRecievedNewReply;

class NotifyMentionedUsers
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
        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);

        foreach ($matches[1] as $name)
        {
            if($user = User::whereName($name)->first())
            {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
