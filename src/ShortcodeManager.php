<?php

namespace DisputeSuite;

use DisputeSuite\Shortcodes\ClientInfoForm;
use DisputeSuite\Shortcodes\Date;
use DisputeSuite\Shortcodes\Ip;
use DisputeSuite\Shortcodes\Service;
use DisputeSuite\Shortcodes\ServiceButton;
use DisputeSuite\Shortcodes\Timestamp;

/**
 * Handles the addition of shortcodes in Wordpress.
 */
class ShortcodeManager
{
    /**
     * @var \DisputeSuite\Shortcodes\AbstractShortcode[]
     */
    private $shortcodes;

    /**
     * Define all the shortcodes here.
     */
    public function __construct()
    {
        $this->shortcodes = [
            new ClientInfoForm(),
            new Date(),
            new Ip(),
            new Service(),
            new ServiceButton(),
            new Timestamp()
        ];
        $this->register();
    }

    /**
     * Registers the queued shortcodes in Wordpress.
     */
    public function register()
    {
        foreach ($this->shortcodes as $shortcode) {
            add_shortcode($shortcode->getCode(), [$shortcode, 'callback']);
        }
    }
}