<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class Element
{
    const CSS_TYPE = 'css';
    const TEXT_TYPE = 'text';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $selector;

    /**
     * @param string $type
     * @param string $selector
     */
    public function __construct($type, $selector)
    {
        $this->type = $type;
        $this->selector = $selector;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }
}
