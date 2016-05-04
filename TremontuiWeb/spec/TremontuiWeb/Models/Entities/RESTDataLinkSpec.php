<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RESTDataLinkSpec extends ObjectBehavior
{
    function Let()
    {
        $this->beConstructedWith('https://api.tramonttest.com');
        $this->shouldHaveType('TremontuiWeb\Models\Entities\RESTDataLink');
    }

    function it_will_always_end_connection_uris_with_a_forward_slash(){
        $this->getConnectionHostURI()->shouldBe('https://api.tramonttest.com/');
    }

    function it_can_add_headers_to_curl_opts(){
        $this->addHeaders('header1: test');

        $this->RESTHeaderCount()->shouldBe(1);
    }

    function it_can_add_several_headers_at_once_to_curl_opt(){
        $this->addHeaders(['header1: test','header2: test']);

        $this->RESTHeaderCount()->shouldBe(2);
    }

    function it_can_set_method_to_get(){
        $this->setGet();

        $this->getMethod()->shouldBe(CURLOPT_HTTPGET);
    }
}
