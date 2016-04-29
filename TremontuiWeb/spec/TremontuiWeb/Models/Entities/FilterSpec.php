<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\Filter;

class FilterSpec extends ObjectBehavior
{
	function Let()
	{
		$field = 'First_Name';
		$operator = Filter::OP_EQ;
		$value = 'Joe';
		$this->beConstructedWith($field, $operator, $value);
		$this->shouldHaveType('TremontuiWeb\Models\Entities\Filter');
	}

	function it_must_have_all_required_properties_filled_with_strings()
	{
		$this->getField()->shouldBe('First_Name');
		$this->getOperator()->shouldBe('==');
		$this->getValue()->shouldBe('Joe');
	}
	function it_can_add_a_conjuction(){
		$this->setConjunction(Filter::CON_AND);

		$this->shouldHaveConjunction();
		$this->getConjunction()->shouldBe('&&');
	}

}
