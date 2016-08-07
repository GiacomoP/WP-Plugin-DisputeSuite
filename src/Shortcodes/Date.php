<?php

namespace DisputeSuite\Shortcodes;

use Respect\Validation\Validator as v;

/**
 * A shortcode to display dates.
 *
 * Usage:
 *
 * - Print the current dd/mm/yyyy date.<br>
 * [date]
 *
 * - Print the date as mm/dd/yyyy.<br>
 * [date format="m/d/Y"]
 *
 * - Format the date of a timestamp<br>
 * [date][timestamp operation="+5 days"][/date]
 */
class Date extends AbstractShortcode
{
    /**
     * Initializes the object, specifying the default attributes.
     */
    public function __construct()
    {
        $defaults = [
            'format' => 'd/m/Y'
        ];
        parent::__construct('date', [$this, 'doDate'], $defaults);
    }

    /**
     * Formats the date to return.
     *
     * @param array     $atts
     * @param string    $content
     *
     * @return string
     */
    public function doDate($atts, $content)
    {
        $timestamp = time();
        $c = do_shortcode($content, true);

        if (v::intVal()->validate($c)) {
            $timestamp = $c;
        }

        return date($atts['format'], $timestamp);
    }
}