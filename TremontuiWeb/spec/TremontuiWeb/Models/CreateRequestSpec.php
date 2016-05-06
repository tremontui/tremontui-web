<?php

namespace spec\TremontuiWeb\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TremontuiWeb\Models\CreateRequest');
    }
}
