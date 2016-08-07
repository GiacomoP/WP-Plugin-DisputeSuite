<?php

namespace DisputeSuite;

use DisputeSuite\Entities\Service as EService;
use DisputeSuite\PostTypes\Service as CPTService;
use DisputeSuite\PostTypes\Step as CPTStep;

/**
 * The bootstrap class.
 */
class App
{
    /**
     * @const string
     */
    const TEXT_DOMAIN = 'dispute-suite';

    /**
     * @var string
     */
    private static $name;

    /**
     * @var string
     */
    private static $version;

    /**
     * @var Controller
     */
    private static $controller;

    /**
     * @var string[]
     */
    private static $registeredPostTypes;

    /**
     * @var EService[]
     */
    private static $services;

    /**
     * Runs the plugin.
     */
    public static function run($version)
    {
        self::$name = 'dispute-suite';
        self::$version = $version;

        self::loadDependencies();
        self::addPostTypes();
        self::loadEntities();

        Loader::run();
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return self::$version;
    }

    /**
     * @return Controller
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * @return array
     */
    public static function getSession()
    {
        return $_SESSION['dispute-suite'];
    }

    /**
     * @return string[]
     */
    public static function getRegisteredPostTypes()
    {
        return self::$registeredPostTypes;
    }

    /**
     * @return EService[]
     */
    public static function getServices()
    {
        return self::$services;
    }

    /**
     * Loads several dependencies that must exist on runtime.
     */
    private static function loadDependencies()
    {
        Notifier::init();

        self::$controller = new Controller();

        new Localization();
        new SessionManager();
        new ShortcodeManager();
    }

    /**
     * Adds the new custom post types.
     */
    private static function addPostTypes()
    {
        self::$registeredPostTypes = [];
        self::$registeredPostTypes[] = (new CPTStep())->register();
        self::$registeredPostTypes[] = (new CPTService())->register();

        // We also need to flush the rewrite rules and add default content
        Loader::addActivationAction(function() {
            flush_rewrite_rules();
            self::addDefaultContent();
        });
        Loader::addDectivationAction('flush_rewrite_rules');
    }

    /**
     * Loads the entities corresponding to Wordpress posts.
     */
    private static function loadEntities()
    {
        Loader::addAction('init', function() {
            try {
                self::$services = EService::fetchAll();
            } catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
                Notifier::showException($e, 'Dispute Suite - Load Entities');
            }
        });
    }

    /**
     * Adds default services and steps.
     */
    private static function addDefaultContent()
    {
        $services = new \WP_Query([
            'post_type' => CPTService::SLUG,
            'post_status' => 'publish'
        ]);
        if ($services->have_posts()) {
            return;
        }

        // Add two services
        $individuals = new EService([
            'title' => _x('Service for Individuals', 'Default Service Title', self::TEXT_DOMAIN),
            'label' => 'Individual',
            'monthlyFee' => 90,
            'setupFee' => 199,
            'hasCoclient' => false,
            'slug' => 'service-for-individuals'
        ]);
        $couples = new EService([
            'title' => _x('Service for Couples', 'Default Service Title', self::TEXT_DOMAIN),
            'label' => 'Couple',
            'monthlyFee' => 140,
            'setupFee' => 249,
            'hasCoclient' => true,
            'slug' => 'service-for-couples'
        ]);
        $individuals->write();
        $couples->write();
    }
}