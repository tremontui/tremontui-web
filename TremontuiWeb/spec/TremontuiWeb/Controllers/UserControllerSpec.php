<?php

namespace spec\TremontuiWeb\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TremontuiWeb\Controllers\User');
    }
}
