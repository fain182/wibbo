<?php

namespace spec\Wibbo\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdminControllerSpec extends ObjectBehavior
{

    function let(\Silex\ControllerCollection $controller)
    {
        $fakeApp = ['controllers_factory' => $controller];
        $this->beConstructedWith($fakeApp);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\Wibbo\Controller\AdminController');
    }

    function it_will_generate_a_controller()
    {
        $this->build()->shouldHaveType('\Silex\ControllerCollection');
    }
}
