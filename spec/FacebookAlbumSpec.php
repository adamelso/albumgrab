<?php

namespace spec\Albumgrab;

use Albumgrab\Element;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class FacebookAlbumSpec extends ObjectBehavior
{
    function let(Element $imageElement, Element $nextButtonElement)
    {
        $this->beConstructedWith('http://fb.me/photos/1', $imageElement, $nextButtonElement);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\FacebookAlbum');
    }

    function it_is_an_album()
    {
        $this->shouldHaveType('Albumgrab\Album');
    }

    function it_has_a_starting_URL()
    {
        $this->getStartingUrl()->shouldBe('http://fb.me/photos/1');
    }

    function it_has_a_image_element(Element $imageElement)
    {
        $this->getImageElement()->shouldReturn($imageElement);
    }

    function it_has_a_next_button_element(Element $nextButtonElement)
    {
        $this->getNextButtonElement()->shouldReturn($nextButtonElement);
    }
}
