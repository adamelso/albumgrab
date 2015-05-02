<?php

namespace spec\Albumgrab;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class ElementSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('css', '#photo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\Element');
    }

    function it_has_a_type()
    {
        $this->getType()->shouldBe('css');
    }

    function it_has_a_selector()
    {
        $this->getSelector()->shouldBe('#photo');
    }
}
