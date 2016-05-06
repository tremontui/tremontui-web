<?php

namespace spec\TremontuiWeb\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\User;

class CreateRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TremontuiWeb\Models\CreateRequest');
    }

    function it_can_be_given_an_object_to_create_in_the_data_source(User $user_obj){
        $user_obj = new User();
        $set_name = 'users';
        $this->addObjects($user_obj);

    }
}
