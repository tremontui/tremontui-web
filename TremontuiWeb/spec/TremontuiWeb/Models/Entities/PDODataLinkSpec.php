<?php

namespace spec\TremontuiWeb\Models\Entities;

use PDO;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\PDODataLink;

class PDODataLinkSpec extends ObjectBehavior
{
	function Let()
	{
		$pdo_conn = new PDO('mysql:dbname=test');
		$this->beConstructedWith($pdo_conn);

		$this->shouldImplement('TremontuiWeb\Models\Entities\DataLink');
		$this->shouldHaveType('TremontuiWeb\Models\Entities\PDODataLink');
	}

	function it_can_get_the_driver_name_for_its_pdo_link()
	{
		$this->getPDODriver()->shouldBe('mysql');
	}

	function it_can_determine_if_the_database_drive_requires_sql(){
		$this->getDataLang()->shouldBe(PDODataLink::DRIVER_LANG_SQL);
	}
}
