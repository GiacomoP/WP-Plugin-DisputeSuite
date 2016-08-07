<?php

namespace DisputeSuite;

/**
 * Class for contents' localization.
 */
class Localization
{
    /**
     * Initializes the object, queueing the loading of the text-domain.
     */
    public function __construct()
    {
        Loader::addAction('init', [$this, 'loadTextDomain']);
    }

    /**
     * Loads the translation file for this plugin.
     * @return boolean
     */
    public function loadTextDomain()
    {
        $name = dirname(dirname(plugin_basename(__FILE__)));
        return load_plugin_textdomain(
            $name,
            false,
            "{$name}/languages/"
        );
    }
}