<?php

if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "redux_dispute_suite_plugin";

$args = [
    'dev_mode' => false,
    'opt_name' => 'redux_dispute_suite_plugin',
    'use_cdn' => true,
    'display_name' => 'Dispute Suite for Wordpress',
    'display_version' => '1.0.0',
    'page_slug' => 'dispute-suite-plugin',
    'page_title' => 'Dispute Suite Plugin Options',
    'update_notice' => true,
    'footer_text' => 'Dispute Suite Plugin for Wordpress - Copyright © 2016 Giacomo Persichini',
    'admin_bar' => true,
    'menu_type' => 'menu',
    'menu_title' => 'Dispute Suite',
    'allow_sub_menu' => true,
    'page_parent_post_type' => 'your_post_type',
    'default_mark' => '*',
    'hints' => [
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => [
            'color' => 'light',
        ],
        'tip_position' => [
            'my' => 'top left',
            'at' => 'bottom right',
        ],
        'tip_effect' => [
            'show' => [
                'duration' => '500',
                'event' => 'mouseover',
            ],
            'hide' => [
                'duration' => '500',
                'event' => 'mouseleave unfocus',
            ],
        ],
    ],
    'output' => true,
    'output_tag' => true,
    'settings_api' => true,
    'cdn_check_time' => '1440',
    'compiler' => true,
    'page_permissions' => 'manage_options',
    'save_defaults' => true,
    'show_import_export' => true,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => true,
    'share_icons' => [
        [
            'url' => 'https://github.com/GiacomoP/WP-Plugin-DisputeSuite',
            'title' => 'Dispute Suite Plugin on GitHub',
            'icon' => 'el el-github'
        ],
        [
            'url' => 'https://www.linkedin.com/in/giacomopersichini',
            'title' => 'Find me on LinkedIn',
            'icon' => 'el el-linkedin'
        ],
        [
            'url' => 'https://www.facebook.com/giacomo.pw/',
            'title' => 'Like me on Facebook',
            'icon' => 'el el-facebook'
        ]
    ]
];

Redux::setArgs($opt_name, $args);

// SECTIONS
Redux::setSection($opt_name, [
    'title' => __('Integrations', 'dispute-suite'),
    'id' => 'basic',
    'icon' => 'el el-cogs'
]);

$hintSystemApi = [
    'title' => 'Where is this?',
    'content' => 'Log in Dispute Suite with an administrator account, then click System API in the navigation menu.'
];

Redux::setSection($opt_name, [
    'id' => 'dispute-suite-api',
    'title' => __('Dispute Suite', 'dispute-suite'),
    'desc' => __('Please configure your API credentials to integrate with Dispute Suite.', 'dispute-suite'),
    'subsection' => true,
    'fields' => [
        [
            'id' => 'dispute-suite-company-key',
            'type' => 'text',
            'title' => __('Company Key', 'dispute-suite'),
            'hint' => $hintSystemApi
        ],
        [
            'id' => 'dispute-suite-api-key',
            'type' => 'password',
            'title' => __('API Key', 'dispute-suite'),
            'hint' => $hintSystemApi
        ],
        [
            'id' => 'dispute-suite-api-url',
            'type' => 'text',
            'title' => __('API URL', 'dispute-suite'),
            'description' => __('Usually, there is no need to modify this field.', 'dispute-suite'),
            'default' => 'https://www.securecrmsite.com/Modules/System/API.asmx',
            'hint' => $hintSystemApi
        ]
    ]
]);

Redux::setSection($opt_name, [
    'id' => 'authorize-net-api',
    'title' => __('Authorize.net', 'dispute-suite'),
    'desc' => __('Please configure your API credentials to integrate with Authorize.net.', 'dispute-suite'),
    'subsection' => true,
    'fields' => [
        [
            'id' => 'authorize-net-login-id',
            'type' => 'text',
            'title' => __('Login ID', 'dispute-suite')
        ],
        [
            'id' => 'authorize-net-transaction-key',
            'type' => 'password',
            'title' => __('Transaction Key', 'dispute-suite')
        ],
        [
            'id' => 'authorize-net-environment',
            'type' => 'switch',
            'title' => __('Account Environment', 'dispute-suite'),
            'on' => 'Regular',
            'off' => 'Sandbox',
            'default' => false
        ]
    ]
]);