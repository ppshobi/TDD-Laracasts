<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase {

    /**
     * @test
     *
     */
    public function it_validates_reply_for_spam_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Normal Text here'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer support spam');
    }

    /**
     * @test
     *
     */
    public function it_checks_for_key_being_held_down()
    {
        $spam = new Spam();

        $this->expectException(\Exception::class);

        $spam->detect('Hello aaaaaaaaaaaaaa');

    }

}
