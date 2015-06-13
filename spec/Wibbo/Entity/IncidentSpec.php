<?php

namespace spec\Wibbo\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IncidentSpec extends ObjectBehavior
{
    function let()
    {
        $organizationId = 15;
        $this->beConstructedWith($organizationId, "An incident description");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Wibbo\Entity\Incident');
    }

    function it_has_a_description()
    {
        $this->getDescription()->shouldBe("An incident description");
    }

    function it_belongs_to_an_organization()
    {
        $this->getOrganizationId()->shouldBe(15);
    }

    function it_is_built_with_current_timestamp_if_missing() {
        $this->getStartTime()->shouldNotBe(null);
    }

}
