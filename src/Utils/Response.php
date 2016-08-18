<?php

namespace DisputeSuite\Utils;

/**
 * Helper class to return JSON responses in AJAX requests.
 */
class Response
{
    /**
     * Sends an error message as a JSON response and terminates the execution.
     *
     * @param string $message
     */
    public static function sendErrorAndDie($message)
    {
        self::sendAndDie(['error' => $message]);
    }

    /**
     * Sends a generic content as a JSON response and terminates the execution.
     *
     * @param mixed $content
     */
    public static function sendAndDie($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content);
        wp_die();
    }
}