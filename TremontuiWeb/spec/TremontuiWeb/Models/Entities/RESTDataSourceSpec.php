<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\Filter;
use TremontuiWeb\Models\Entities\ReadRequest;
use TremontuiWeb\Models\Entities\RESTDataLink;
use TremontuiWeb\Models\Entities\User;

class RESTDataSourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement('TremontuiWeb\Models\Entities\DataSource');
        $this->shouldHaveType('TremontuiWeb\Models\Entities\RESTDataSource');
    }

    function it_can_set_a_rest_uri_data_link(RESTDataLink $rest_data_link){
        $this->setDataLink($rest_data_link);

        $this->shouldHaveRestURIDataLink();
    }

    /*function it_can_convert_a_read_request_to_be_sent_as_a_curl_http_request(RESTDataLink $rest_data_link){
        $this->setDataLink($rest_data_link);
        $read_request = new ReadRequest();

        $entity = new User();
        $filter1 = new Filter('First_Name', '==', 'admin');
        $read_request->defineFields(['ID','First_Name','Last_Name', 'Email']);
        $read_request->defineSubjectEntity($entity,[] , 'users');
        $read_request->defineFilters([$filter1]);

        $this->read($read_request);
        $this->getLastRESTReadCUrl()->shouldBe(NULL);
    }*/
}
