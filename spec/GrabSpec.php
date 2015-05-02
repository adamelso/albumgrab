<?php

namespace spec\Albumgrab;

use Albumgrab\Album;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class GrabSpec extends ObjectBehavior
{
    function let(Album $album)
    {
        $this->beConstructedWith($album, '/tmp');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\Grab');
    }

    function it_records_visited_URLs()
    {
        $this->addVisitedUrl('http://fb.me/photos/1');

        $this->shouldHaveVisitedUrl('http://fb.me/photos/1');
    }

    function it_is_countable()
    {
        $this->count()->shouldEqual(0);

        $this->addVisitedUrl('http://fb.me/photos/1');
        $this->addVisitedUrl('http://fb.me/photos/2');

        $this->count()->shouldEqual(2);
    }

    function it_records_image_URLs()
    {
        $this->addImageUrl('http://fb.me/photos/1.jpg');

        $this->shouldHaveImageUrl('http://fb.me/photos/1.jpg');
    }

    function it_has_an_album(Album $album)
    {
        $this->getAlbum()->shouldReturn($album);
    }

    function it_exposes_the_image_URLs()
    {
        $this->addImageUrl('http://fb.me/photos/1.jpg');
        $this->addImageUrl('http://fb.me/photos/2.jpg');

        $this->getImageUrls()->shouldBe(['http://fb.me/photos/1.jpg', 'http://fb.me/photos/2.jpg']);
    }

    function it_has_a_directory_path_to_save_images_to()
    {
        $this->getSavePath()->shouldBe('/tmp');
    }
}
