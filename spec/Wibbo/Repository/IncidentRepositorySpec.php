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
        $db->fetchAll(Argument::any(), [12])
          ->willReturn([['id'=>2, 'description'=>'abc', 'start'=>'2015-06-13 12:22:21', 'organization_id'=>12 ]]);
        $db->fetchAll(Argument::any(), [13])
          ->willReturn([['avg_minutes_duration'=>'78']]);
        $db->update("incidents", ["description" => "abc"], ["id" => 12])->willReturn(1);

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

    function it_can_update_an_incident()
    {
        $this->update(12, ['description'=>'abc'])->shouldReturn(true);
    }

    function it_can_retrieve_all_incident_active_now()
    {
        $this->getAllActiveNow(12)->shouldHaveCount(1);
    }

    function it_can_retrieve_average_incident_duration()
    {
        $this->getAverageIncidentDurationInMinutes(13)->shouldBe('78');
    }

}
