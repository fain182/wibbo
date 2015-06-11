<?php

namespace spec\Wibbo\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrganizationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('nome');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Wibbo\Entity\Organization');
    }

    function it_knows_its_name()
    {
        $this->getName()->shouldReturn('nome');
    }

}
