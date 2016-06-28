<?php

namespace spec\TremontuiWeb\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\TremontuiWeb\Models\Entities\PDODataSource;
use TremontuiWeb\Models\Entities\User;
use TremontuiWeb\Models\Entities\DataSource;

class UserServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TremontuiWeb\Models\UserService');
    }

    function it_can_store_to_a_user_collection(User $user){
        $this->addUser($user);

        $this->userCount()->shouldBe(1);
    }

    function it_can_set_a_datasource(DataSource $data_source){
        $this->setDataSource($data_source);

        $this->shouldHaveDataSource();
    }
}
