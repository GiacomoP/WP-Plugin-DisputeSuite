<?php

namespace DisputeSuite\PostTypes;

use DisputeSuite\App;

/**
 * A service that customers can purchase while signing up.
 */
class Service extends AbstractPostType implements PostTypeInterface
{
    /**
     * @const string
     */
    const SLUG = 'ds-service';

    public function __construct()
    {
        $labels = [
            'name'          => _x('Services', 'Post Type General Name', App::TEXT_DOMAIN),
            'singular_name' => _x('Service', 'Post Type Singular Name', App::TEXT_DOMAIN)
        ];

        $rewrite = [
            'slug'          => self::SLUG,
            'with_front'    => false,
            'pages'         => false,
            'feeds'         => false
        ];

        $this->name = self::SLUG;
        $this->args = [
            'label'                 => _x('Services', 'Post Type Label', App::TEXT_DOMAIN),
            'description'           => _x('The services you wish to offer', 'Post Type Description', App::TEXT_DOMAIN),
            'labels'                => $labels,
            'supports'              => ['title', 'custom-fields', 'thumbnail'],
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => false,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
            'query_var'             => true
        ];
    }
}