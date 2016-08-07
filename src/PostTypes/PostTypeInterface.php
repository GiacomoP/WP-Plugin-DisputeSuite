<?php

namespace DisputeSuite\PostTypes;

/**
 * Common interface for Post Types in this plugin.
 */
interface PostTypeInterface
{
    /**
     * Registers the new Post Type in Wordpress.
     */
    public function register();
}