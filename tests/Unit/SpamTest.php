<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase {

    /**
     * @test
     *
     */
    public function it_validates_text_for_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Normal Text here'));

        $this->assertTrue($spam->detect('click me spam here'));
    }

}
