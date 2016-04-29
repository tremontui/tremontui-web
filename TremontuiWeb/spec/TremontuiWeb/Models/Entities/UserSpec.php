<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('TremontuiWeb\Models\Entities\User');
	}

	function it_can_be_given_a_datasource_id(){
		$id = 23;
		$this->setID($id);

		$this->shouldHaveID();
		$this->getID()->shouldBe($id);
	}

	function it_can_be_given_a_username()
	{
		$username = "adminjones123";
		$this->setUsername($username);

		$this->shouldHaveUsername();
		$this->getUsername()->shouldBe($username);
	}

	function it_can_be_given_a_first_name()
	{
		$first_name = "Admin";
		$this->setFirstName($first_name);

		$this->shouldHaveFirstName();
		$this->getFirstName()->shouldBe($first_name);
	}

	function it_can_be_given_a_last_name()
	{
		$last_name = "Jones";
		$this->setLastName($last_name);

		$this->shouldHaveLastName();
		$this->getLastName()->shouldBe($last_name);
	}

	function it_can_be_given_an_email()
	{
		$email = "admin@tremontui.com";
		$this->setEmail($email);

		$this->shouldHaveEmail();
		$this->getEmail()->shouldBe($email);
	}

	function it_can_be_given_a_safe_password()
	{
		$password = "correct_password";
		$this->setPassword($password);

		$this->shouldHaveSafePassword();
		$this->getPasswordHash()->shouldBeString();
		$this->getPasswordHash()->shouldNotBe($password);
	}

	function it_can_verify_against_a_safe_password()
	{
		$password = "correct_password";
		$this->setPassword($password);

		$this->verifyPassword($password)->shouldBe(TRUE);
		$this->verifyPassword("wrong_password")->shouldNotBe(TRUE);
	}
}
