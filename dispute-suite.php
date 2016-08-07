<?php

/**
 * Plugin Name: Dispute Suite for Wordpress
 * Description: A plugin to integrate Dispute Suite in Wordpress.
 * Version: 1.0.0
 * Author: Giacomo Persichini
 * Author URI: http://giacomo.pw
 * Text Domain: dispute-suite
 * License: GNU AGPLv3
 * License URI: https://www.gnu.org/licenses/agpl-3.0.en.html
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Composer
require_once 'vendor/autoload.php';

use DisputeSuite\App;

App::run('1.0.0');

register_activation_hook(__FILE__, ['\DisputeSuite\Loader', 'runActivation']);
register_deactivation_hook(__FILE__, ['\DisputeSuite\Loader', 'runDeactivation']);