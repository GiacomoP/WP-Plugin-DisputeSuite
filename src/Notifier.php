<?php

namespace DisputeSuite;

use Respect\Validation\Validator as v;

/**
 * Displays admin notices in Wordpress.
 */
class Notifier
{
    /**
     * @var array
     */
    private static $notices;

    /**
     * Initializes the object, waiting to display enqueued notifications.
     */
    public static function init()
    {
        self::$notices = [];

        Loader::addAction('admin_notices', [get_class(), 'printMessages']);
    }

    /**
     * Displays a PHP Exception and its extending classes.
     *
     * @param \Exception    $e                  The exception to show.
     * @param string        $module [optional]  An indication where the exception has been thrown.
     */
    public static function showException(\Exception $e, $module = 'Dispute Suite') {
        $reflect = new \ReflectionClass($e);
        $message = sprintf(_x('An exception of class "%s" was thrown in %s:%s', 'Admin Notice for Exceptions', App::TEXT_DOMAIN), $reflect->getShortName(), $module, '<br>');
        if (v::instance('\Respect\Validation\Exceptions\NestedValidationException')->validate($e)) {
            $message .= str_replace(PHP_EOL, '<br>', $e->getFullMessage());
        } else {
            $message .= $e->getMessage();
        }
        self::showError($message);
    }

    /**
     * Displays a warning notice.
     * @param string $message
     */
    public static function showWarning($message)
    {
        self::addNotice('warning', $message);
    }

    /**
     * Displays a success notice.
     * @param string $message
     */
    public static function showSuccess($message)
    {
        self::addNotice('success', $message);
    }

    /**
     * Displays an info notice.
     * @param string $message
     */
    public static function showInfo($message)
    {
        self::addNotice('info', $message);
    }

    /**
     * Displays an error notice.
     * @param string $message
     */
    public static function showError($message)
    {
        self::addNotice('error', $message);
    }

    /**
     * Prints all the enqueued messages.
     */
    public static function printMessages()
    {
        foreach (self::$notices as $notice) {
            $class = "notice notice-{$notice['type']}";
            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $notice['message']);
        }
    }

    /**
     * Adds a notice to the queue.
     *
     * @param string $type
     * @param string $message
     */
    private static function addNotice($type, $message)
    {
        self::$notices[] = [
            'type' => $type,
            'message' => $message
        ];
    }
}