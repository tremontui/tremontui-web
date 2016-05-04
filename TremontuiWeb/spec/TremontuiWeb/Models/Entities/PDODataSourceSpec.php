<?php

namespace spec\TremontuiWeb\Models\Entities;

use TremontuiWeb\Models\Entities\Filter;
use TremontuiWeb\Models\Entities\PDODataLink;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\ReadRequest;
use TremontuiWeb\Models\Entities\User;

class PDODataSourceSpec extends ObjectBehavior
{
	function it_is_initializable()
	{
		$this->shouldImplement('TremontuiWeb\Models\Entities\DataSource');
		$this->shouldHaveType('TremontuiWeb\Models\Entities\PDODataSource');
	}

	function it_can_set_a_pdo_data_link(PDODataLink $data_link)
	{
		$this->setDataLink($data_link);

		$this->shouldHavePDODataLink();
	}

	function it_can_convert_a_read_request_into_sql_for_use_with_pdo()
	{
		$pdo_conn = new \PDO('mysql:dbname=test');
		$data_link = new PDODataLink($pdo_conn);
		$this->setDataLink($data_link);

		$filter1 = new Filter('First_Name', '==', 'admin');
		$read_request = new ReadRequest();
		$read_request->defineFields(['ID', 'First_Name', 'Last_Name']);
		$read_request->defineSubjectEntity(new User(),[] , 'users');
		$read_request->defineFilters([$filter1]);

		$this->read($read_request);

		$this->getLastReadSQL()->shouldBe("SELECT ID,First_Name,Last_Name FROM users WHERE First_Name = :First_Name");
	}

}
