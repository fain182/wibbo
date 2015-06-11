<?php

namespace spec\Wibbo\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Wibbo\Entity\Organization;

class OrganizationRepositorySpec extends ObjectBehavior
{
    function let( Connection $db)
    {
        $db->insert("organization", ["name" => "abc"])->willReturn(1);
        $this->beConstructedWith($db);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Wibbo\Repository\OrganizationRepository');
    }

    function it_can_save_a_new_organization()
    {
        $organization = new Organization('abc');
        $this->add($organization)->shouldReturn(true);
    }
}
