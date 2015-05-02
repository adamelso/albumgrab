<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class RemoteResourceClient
{
    /**
     * @param string $url
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getResource($url)
    {
        $resource = @file_get_contents($url);

        if (! $resource) {
            throw new \RuntimeException(sprintf('Unable to download image "%s".', $url));
        }

        return $resource;
    }
}
