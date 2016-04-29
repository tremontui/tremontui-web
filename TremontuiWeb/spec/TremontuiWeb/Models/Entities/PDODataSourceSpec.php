<?php

namespace spec\TremontuiWeb\Models\Entities;

use TremontuiWeb\Models\Entities\PDODataLink;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\ReadRequest;

class PDODataSourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement('TremontuiWeb\Models\Entities\DataSource');
        $this->shouldHaveType('TremontuiWeb\Models\Entities\PDODataSource');
    }

    function it_can_set_a_pdo_data_link(PDODataLink $data_link){
        $this->setDataLink($data_link);

        $this->shouldHavePDODataLink();
    }

    function it_can_convert_a_read_request_into_sql_for_use_with_pdo(){
        $read_request = new ReadRequest();
        $this->read($read_request);

        $this->getLastReadSQL()->shouldBe("SELECT ID,First_Name,Last_Name FROM users WHERE First_Name = 'admin'");
    }

    /*function it_can_read_data_from_a_pdo_data_link(PDODataLink $data_link, ReadRequest $read_request){
        $this->setDataLink($data_link);

        $this->read($read_request)->shouldBeString();
    }*/
}
