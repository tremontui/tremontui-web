<?php

namespace spec\TremontuiWeb\Models\Entities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TremontuiWeb\Models\Entities\Filter;
use TremontuiWeb\Models\Entities\User;

class ReadRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TremontuiWeb\Models\Entities\ReadRequest');
    }

    function it_can_be_given_a_subject_entity_to_expect_to_read(User $user_entity){
        $this->defineSubjectEntity($user_entity);

        $this->shouldHaveSubjectEntity();
    }

    function it_can_designate_fields_to_limit_returns(){
        $this->defineFields(['ID','First_Name','Last_Name']);

        $this->getFields()->shouldBeArray();
        $this->getFields()->shouldHaveCount(3);
    }

    function it_can_filter_read_fields_for_limiting_returns(Filter $filter){
        $this->defineFilters([$filter]);

        $this->getFilters()->shouldBeArray();
        $this->getFilters()->shouldHaveCount(1);
    }
}
