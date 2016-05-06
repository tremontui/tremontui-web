<?php

namespace spec\TremontuiWeb\Controllers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\RESTDataLink;

class UserControllerSpec extends ObjectBehavior
{
    function let(RESTDataLink $rest_link)
    {
        $this->beConstructedWith($rest_link);
        $this->shouldHaveType('TremontuiWeb\Controllers\UserController');
    }

    function it_should_have_a_data_source(){
        $this->shouldHaveDataSource();
    }

}
