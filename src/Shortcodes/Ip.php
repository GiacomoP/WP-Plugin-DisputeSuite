<?php

namespace DisputeSuite\Shortcodes;

/**
 * A shortcode to display the user's IP.
 *
 * Usage: [ip]
 */
class Ip extends AbstractShortcode
{
    /**
     * Initializes the object.
     */
    public function __construct()
    {
        parent::__construct('ip', [$this, 'doIp']);
    }

    /**
     * Returns the client's IP.
     *
     * @return string
     */
    public function doIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}