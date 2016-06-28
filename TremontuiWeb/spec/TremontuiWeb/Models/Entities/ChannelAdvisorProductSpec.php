<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelAdvisorProductSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldHaveType('TremontuiWeb\Models\Entities\ChannelAdvisorProduct');
	}

	function it_can_be_given_a_sku()
	{
		$sku = 'TESTSKU';
		$this->sku = $sku;

		$this->shouldHaveSku();
		$this->sku->shouldBe($sku);

	}

	function it_can_be_given_a_title()
	{
		$title = 'This is a test product';
		$this->title = $title;

		$this->shouldHaveTitle();
		$this->title->shouldBe($title);

	}

	function it_can_be_tested_to_have_the_reequired_properties_to_create_a_new_channel_advisor_product(){

		$title = 'This is a test product';
		$sku = 'TESTSKU';

		$this->sku = $sku;
		$this->title = $title;

		$this->validateCreatable()->shouldBe(TRUE);
	}


}
