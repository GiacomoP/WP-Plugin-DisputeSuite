<?php

namespace DisputeSuite;

use Respect\Validation\Validator as v;

/**
 * Handles the current page and enqueues resources.
 */
class Controller
{
    /**
     * @var string The (relative) requested path.
     */
    private $requestPath;

    /**
     * @var string The currently requested post's type.
     */
    private $postType;

    /**
     * @var string The currently requested post's slug.
     */
    private $postSlug;

    /**
     * Enqueues the actions required to handle the user request and to insert resources.
     */
    public function __construct()
    {
        Loader::addAction('parse_request', [$this, 'parseRequest']);
        Loader::addAction('wp_enqueue_scripts', [$this, 'addHighPriorityResources'], -1);
        Loader::addAction('wp_enqueue_scripts', [$this, 'addStyles'], PHP_INT_MAX);
        Loader::addAction('wp_enqueue_scripts', [$this, 'addScripts']);
    }

    /**
     * Parses the current request into the object's attributes.
     * @param \stdClass $query
     */
    public function parseRequest($query)
    {
        $this->requestPath = $query->request;
        $vars = $query->query_vars;

        if (v::key('post_type', v::in(App::getRegisteredPostTypes()))->validate($vars)) {
            $this->postType = $vars['post_type'];
            $this->postSlug = $vars['name'];
        }
    }

    /**
     * Enqueues high priority resources.
     */
    public function addHighPriorityResources()
    {
        if (!$this->isPluginPage()) {
            return;
        }
        wp_enqueue_style('purecss-base', plugin_dir_url(__FILE__) . '../assets/css/libs/pure-min.css', null, App::getVersion());
        wp_enqueue_style('purecss-grids', plugin_dir_url(__FILE__) . '../assets/css/libs/grids-responsive-min.css', ['purecss-base'], App::getVersion());
        wp_enqueue_style('remodal', plugin_dir_url(__FILE__) . '../assets/css/libs/remodal.css', null, App::getVersion());
        wp_enqueue_style('remodal-default-theme', plugin_dir_url(__FILE__) . '../assets/css/libs/remodal-default-theme.css', ['remodal'], App::getVersion());
    }

    /**
     * Enqueues CSS files.
     */
    public function addStyles()
    {
        // Buttons can be used anywhere, enqueue their specific CSS
        wp_enqueue_style('ds-services-buttons', plugin_dir_url(__FILE__) . '../assets/css/services-buttons.css', [], App::getVersion());

        if (!$this->isPluginPage()) {
            return;
        }
        $dependencies = [
            'purecss-base',
            'purecss-grids',
            'remodal-default-theme'
        ];
        wp_enqueue_style('ds-main', plugin_dir_url(__FILE__) . '../assets/css/app.css', $dependencies, App::getVersion());
    }

    /**
     * Enqueues JS files.
     */
    public function addScripts()
    {
        if (!$this->isPluginPage()) {
            return;
        }

        wp_enqueue_script('jquery-remodal', plugin_dir_url(__FILE__) . '../assets/js/libs/remodal.min.js', ['jquery'], App::getVersion(), true);
        wp_enqueue_script('jquery-maskedinput', plugin_dir_url(__FILE__) . '../assets/js/libs/jquery.maskedinput.min.js', ['jquery'], App::getVersion(), true);
        wp_enqueue_script('jquery-validate', plugin_dir_url(__FILE__) . '../assets/js/libs/validate/jquery.validate.min.js', ['jquery'], App::getVersion(), true);
        wp_enqueue_script('jquery-validate-additional', plugin_dir_url(__FILE__) . '../assets/js/libs/validate/additional-methods.min.js', ['jquery-validate'], App::getVersion(), true);
        wp_enqueue_script('ds-main', plugin_dir_url(__FILE__) . '../assets/js/main.min.js', ['jquery', 'jquery-maskedinput', 'jquery-validate'], App::getVersion(), true);

        // JS Object for backend stuff
        wp_localize_script('ds-main', 'dsConfig', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'homeUrl' => home_url(),
            'pluginUrl' => plugin_dir_url(dirname(__FILE__))
        ]);
    }

    /**
     * @return boolean
     */
    private function isPluginPage()
    {
        return !v::nullType()->validate($this->postType);
    }
}