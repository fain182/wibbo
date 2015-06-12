<?php

namespace spec\Wibbo\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Wibbo\Entity\Organization;

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

    function it_can_be_generated_from_a_row()
    {
        $row = ['id' => 1, 'name' => 'abc'];
        $this::fromRow($row)->id->shouldBe(1);
        $this::fromRow($row)->name->shouldBe('abc');
    }
}
