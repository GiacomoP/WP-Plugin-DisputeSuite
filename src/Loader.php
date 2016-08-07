<?php

namespace DisputeSuite;

use Respect\Validation\Validator as v;

/**
 * Helper class to add Wordpress actions/filters.
 */
class Loader
{
    /**
     * @var array
     */
    private static $actions = [];

    /**
     * @var array
     */
    private static $activation = [];

    /**
     * @var array
     */
    private static $deactivation = [];

    /**
     * Adds an action/filter to the queue.
     *
     * @param string|string[]   $hook       The name of the Wordpress hook(s).
     * @param callable          $callback   The callback function.
     * @param int               $priority   [optional] The priority for this action.
     * @param int               $args       [optional] The number of arguments the callback takes.
     */
    public static function addAction($hook, callable $callback, $priority = 10, $args = 1)
    {
        $hooks = v::arrayType()->validate($hook) ? $hook : [$hook];

        foreach ($hooks as $hook) {
            self::$actions[] = [
                'hook' => $hook,
                'callback' => $callback,
                'priority' => $priority,
                'args' => $args
            ];
        }
    }

    /**
     * Adds a callback to the plugin activation hook.
     * @param callable $callback
     */
    public static function addActivationAction(callable $callback)
    {
        self::$activation[] = $callback;
    }

    /**
     * Adds a callback to the plugin deactivation hook.
     * @param callable $callback
     */
    public static function addDectivationAction(callable $callback)
    {
        self::$deactivation[] = $callback;
    }

    /**
     * Registers in Wordpress all the enqueued actions.
     */
    public static function run()
    {
        foreach (self::$actions as $action) {
            add_action($action['hook'], $action['callback'], $action['priority'], $action['args']);
        }
    }

    /**
     * Runs the registered callbacks.
     */
    public static function runActivation()
    {
        foreach (self::$activation as $func) {
            call_user_func($func);
        }
    }

    /**
     * Runs the registered callbacks.
     */
    public static function runDeactivation()
    {
        foreach (self::$deactivation as $func) {
            call_user_func($func);
        }
    }
}