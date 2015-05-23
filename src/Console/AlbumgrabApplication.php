<?php

namespace Albumgrab\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class AlbumgrabApplication extends Application implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
