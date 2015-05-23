<?php

namespace spec\Albumgrab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AlbumgrabApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\Console\AlbumgrabApplication');
    }

    function it_has_a_service_container()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\ContainerAwareInterface');
    }

    function it_exposes_the_service_container(ContainerInterface $container)
    {
        $this->setContainer($container);

        $this->getContainer()->shouldReturn($container);
    }
}
