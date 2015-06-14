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
        $db->insert("organizations", ["name" => "abc"])->willReturn(1);
        $db->fetchAll(Argument::any())->willReturn([ ['id'=>1, 'name'=>'abc'] ]);
        $db->delete("organizations", ["id" => 1])->willReturn(1);

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

    function it_can_retrieve_all_organizations()
    {
        $this->getAll()->shouldBeLike([new Organization('abc', 1)]);
    }

    function it_can_delete_organizations()
    {
        $this->deleteById(1)->shouldReturn(true);
    }

}
