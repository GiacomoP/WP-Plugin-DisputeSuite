<?php

namespace DisputeSuite\PostTypes;

use DisputeSuite\App;

/**
 * A page representing a step in the sign up procedure.
 */
class Step extends AbstractPostType implements PostTypeInterface
{
    /**
     * @const string
     */
    const SLUG = 'ds-step';

    public function __construct()
    {
        $labels = [
            'name'          => _x('Steps', 'Post Type General Name', App::TEXT_DOMAIN),
            'singular_name' => _x('Step', 'Post Type Singular Name', App::TEXT_DOMAIN)
        ];

        $rewrite = [
            'slug'          => self::SLUG,
            'with_front'    => true,
            'pages'         => true,
            'feeds'         => true
        ];

        $this->name = self::SLUG;
        $this->args = [
            'label'                 => _x('Steps', 'Post Type Label', App::TEXT_DOMAIN),
            'description'           => _x('The plugin steps', 'Post Type Description', App::TEXT_DOMAIN),
            'labels'                => $labels,
            'supports'              => ['title', 'editor', 'custom-fields', 'page-attributes', 'thumbnail'],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
            'query_var'             => true
        ];
    }
}