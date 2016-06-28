<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\User;

class UserCollectionSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('TremontuiWeb\Models\Entities\UserCollection');
	}

	function it_can_add_users_to_its_collection(User $user)
	{
		$this->add($user);

		$this->shouldHaveCount(1);
	}

	function it_can_get_a_user_by_index(User $user1, User $user2)
	{
		$this->add($user1);
		$this->add($user2);

		$this->getUser(0)->shouldBe($user1);
		$this->getUser(0)->shouldNotBe($user2);
	}

	function it_can_get_a_user_by_username(User $user1, User $user2)
	{
		$user1 = new User();
		$username = 'admin';
		$user1->setUsername($username);
		$this->add($user1);
		$this->add($user2);

		$this->getUser($username)->shouldBe($user1);
		$this->getUser($username)->shouldNotBe($user2);
	}

	function it_can_get_the_first_user(User $user1, User $user2, User $user3)
	{
		$this->add($user1);
		$this->add($user2);
		$this->add($user3);

		$this->getFirstUser()->shouldBe($user1);
	}

	function it_can_get_the_most_recently_added_user(User $user1, User $user2, User $user3)
	{
		$this->add($user1);
		$this->add($user2);
		$this->add($user3);

		$this->getLastUser()->shouldBe($user3);
	}
}
