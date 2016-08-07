<?php

namespace DisputeSuite\PostTypes;

use DisputeSuite\Loader;

/**
 * Base class for Custom Post Types.
 */
abstract class AbstractPostType implements PostTypeInterface
{
    /**
     * @var string The name of the Custom Post Type.
     */
    protected $name;

    /**
     * @var array The 'args' for register_post_type().
     */
    protected $args;

    /**
     * Registers the new Post Type in Wordpress.
     * @return string The post type name.
     */
    public function register()
    {
        $callback = function() {
            register_post_type($this->name, $this->args);
        };
        Loader::addAction('init', $callback);
        Loader::addActivationAction($callback);

        return $this->name;
    }
}