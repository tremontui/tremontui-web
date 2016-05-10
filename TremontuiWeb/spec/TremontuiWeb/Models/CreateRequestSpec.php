<?php

namespace spec\TremontuiWeb\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\User;

class CreateRequestSpec extends ObjectBehavior
{
	function let()
	{
		$set_name = 'users';
		$this->beConstructedWith($set_name);

		$this->getSetName()->shouldBe('users');
		$this->shouldHaveType('TremontuiWeb\Models\CreateRequest');
	}

	function it_validates_a_creatable_before_adding_it_to_creation_array(User $user_obj)
	{
		$user_obj = new User();

		$this->add($user_obj)->shouldBe(FALSE);
	}

	function it_can_be_given_an_object_to_create_in_the_data_source(User $user_obj)
	{
		$user_obj = new User();
		$user_obj->setUsername('joejones123');
		$user_obj->setFirstName('joe');
		$user_obj->setLastName('jones');
		$user_obj->setEmail('joejones@gmail.com');
		$user_obj->setPassword('awesomepass');
		
		$this->add($user_obj);

		$this->objectCount()->shouldBe(1);

	}

	function it_can_add_multiple_objects_at_a_time(User $user_obj1, User $user_obj2){
		$user_obj1 = new User();
		$user_obj1->setUsername('joejones123');
		$user_obj1->setFirstName('joe');
		$user_obj1->setLastName('jones');
		$user_obj1->setEmail('joejones@gmail.com');
		$user_obj1->setPassword('awesomepass');
		$user_obj2 = new User();
		$user_obj2->setUsername('janejones123');
		$user_obj2->setFirstName('jane');
		$user_obj2->setLastName('jones');
		$user_obj2->setEmail('janejones@gmail.com');
		$user_obj2->setPassword('awesomepass');

		$this->addArray([$user_obj1,$user_obj2])->shouldNotBe(FALSE);
		$this->objectCount()->shouldBe(2);
	}

	function it_locks_its_creation_type_on_first_add()
	{
		$user_obj = new User();
		$user_obj->setUsername('joejones123');
		$user_obj->setFirstName('joe');
		$user_obj->setLastName('jones');
		$user_obj->setEmail('joejones@gmail.com');
		$user_obj->setPassword('awesomepass');

		$this->add($user_obj);

		$this->getTypeLock()->shouldBe('TremontuiWeb\Models\Entities\User');
	}
}
