<?php

namespace spec\Wibbo\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Wibbo\Entity\Incident;

class IncidentRepositorySpec extends ObjectBehavior
{

    function let( Connection $db)
    {
        $db->insert("incidents", Argument::any())->willReturn(1);
        $this->beConstructedWith($db);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Wibbo\Repository\IncidentRepository');
    }

    function it_can_save_a_new_incident()
    {
        $incident = new Incident(12, 'a description');
        $this->add($incident)->shouldReturn(true);
    }

}
