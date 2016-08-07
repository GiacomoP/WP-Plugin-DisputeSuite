<?php

namespace DisputeSuite\Shortcodes;

use Respect\Validation\Validator as v;

/**
 * A shortcode to display timestamps and do operations with them.
 *
 * Usage:
 *
 * - Print the current timestamp.<br>
 * [timestamp]
 *
 * - Print the timestamp 5 weekdays from now.<br>
 * [timestamp operation="+5 weekdays"]
 *
 * - Get the time 5 days from now, and print the timestamp 5 weekdays after that one.<br>
 * [timestamp operation="+5 weekdays"][timestamp operation="+5 days"][/timestamp]
 */
class Timestamp extends AbstractShortcode
{
    /**
     * Initializes the object, specifying the default attributes.
     */
    public function __construct()
    {
        $defaults = [
            'operation' => ''
        ];
        parent::__construct('timestamp', [$this, 'doTimestamp'], $defaults);
    }

    /**
     * Computes the timestamp to return.
     *
     * @param array     $atts
     * @param string    $content
     *
     * @return string
     */
    public function doTimestamp($atts, $content)
    {
        $return = time();
        $c = do_shortcode($content, true);
        $opToDo = v::key('operation', v::stringType()->notEmpty())->validate($atts);

        if ($opToDo
            && v::intVal()->notEmpty()->validate($c)
        ) {
            $return = strtotime($atts['operation'], $c);
        } elseif ($opToDo) {
            $return = strtotime($atts['operation'], time());
        }

        // Error checking
        if (!$return) {
            $return = "<i><strong>ERROR:</strong> the [timestamp] operation {$atts['operation']} is not valid.</i>";
        }

        return $return;
    }
}