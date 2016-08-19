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
    'id' => 'integrations',
    'icon' => 'el el-cogs'
]);

$hintDsApi = [
    'title' => __('Where is this?', 'dispute-suite'),
    'content' => __('Log in Dispute Suite with an administrator account, then click System API in the navigation menu.', 'dispute-suite')
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
            'hint' => $hintDsApi,
            'validate' => 'not_empty'
        ],
        [
            'id' => 'dispute-suite-api-key',
            'type' => 'password',
            'title' => __('API Key', 'dispute-suite'),
            'hint' => $hintDsApi,
            'validate' => 'not_empty'
        ],
        [
            'id' => 'dispute-suite-api-url',
            'type' => 'text',
            'title' => __('API URL', 'dispute-suite'),
            'description' => __('Usually, there is no need to modify this field.', 'dispute-suite'),
            'default' => 'https://www.securecrmsite.com/Modules/System/API.asmx',
            'hint' => $hintDsApi,
            'validate' => 'url'
        ],
        [
            'id' => 'dispute-suite-api-connection',
            'type' => 'javascript_button',
            'title' => __('Connection', 'dispute-suite'),
            'description' => __('You should fetch new data from Dispute Suite every time you add a new record type, customer status, etc...<br>This will also test the connection to Dispute Suite.', 'dispute-suite'),
            'button_text' => __('Test &amp; fetch data', 'dispute-suite')
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
            'title' => __('Login ID', 'dispute-suite'),
            'hint' => [
                'title' => __('Where is this?', 'dispute-suite'),
                'content' => __('Log in your merchant account. Click <i>Account</i> on the navigation bar. Under <i>General Security Settings</i>, click on <i>API Credentials &amp; Keys</i>', 'dispute-suite')
            ],
            'validate' => 'not_empty'
        ],
        [
            'id' => 'authorize-net-transaction-key',
            'type' => 'password',
            'title' => __('Transaction Key', 'dispute-suite'),
            'hint' => [
                'title' => __('Where is this?', 'dispute-suite'),
                'content' => __('Log in your merchant account. Click <i>Account</i> on the navigation bar. Under <i>General Security Settings</i>, click on <i>API Credentials &amp; Keys</i><br>There, generate a new transaction key.', 'dispute-suite')
            ],
            'validate' => 'not_empty'
        ],
        [
            'id' => 'authorize-net-environment',
            'type' => 'switch',
            'title' => __('Account Environment', 'dispute-suite'),
            'on' => 'Regular',
            'off' => 'Sandbox',
            'default' => false,
            'hint' => [
                'title' => __('What is this?', 'dispute-suite'),
                'content' => __('Simply select the type of your merchant account. There are two types: one for developers (Sandbox), one for real merchants (Regular).', 'dispute-suite')
            ]
        ]
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Sign Up Procedure', 'dispute-suite'),
    'id' => 'signup',
    'icon' => 'el el-pencil'
]);

Redux::setSection($opt_name, [
    'id' => 'sign-up-userinfo',
    'title' => __('User Information Submitted', 'dispute-suite'),
    'desc' => __("<p>When a user submits their personal information (Step 1), a new Lead/Customer will be created in Dispute Suite.</p><p>Here you can specify the <strong>Dispute Suite Customer</b> entity's attributes.</p>", 'dispute-suite'),
    'subsection' => true,
    'fields' => [
        [
            'id' => 'userinfo-record-type',
            'type' => 'select',
            'title' => __('Record Type', 'dispute-suite')
        ],
        [
            'id' => 'userinfo-status',
            'type' => 'select',
            'title' => __('Status', 'dispute-suite')
        ],
        [
            'id' => 'userinfo-folder',
            'type' => 'select',
            'title' => __('Folder', 'dispute-suite')
        ],
        [
            'id' => 'userinfo-sales-rep',
            'type' => 'select',
            'title' => __('Sales Representative', 'dispute-suite'),
            'multi' => true
        ],
        [
            'id' => 'userinfo-case-agent',
            'type' => 'select',
            'title' => __('Assigned To', 'dispute-suite')
        ],
        [
            'id' => 'userinfo-workflow',
            'type' => 'select',
            'title' => __('Workflow', 'dispute-suite')
        ]
    ]
]);