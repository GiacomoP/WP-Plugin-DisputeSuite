<?php

namespace DisputeSuite\Shortcodes;

/**
 * Base class for Shortcodes.
 */
abstract class AbstractShortcode
{
    /**
     * @var string The name to use.
     */
    protected $code;

    /**
     * @var callable The callback in the extending class.
     */
    protected $callback;

    /**
     * @var array
     */
    protected $defaults;

    /**
     * Initializes the attributes.
     *
     * @param string    $code       The name to use.
     * @param callable  $callback   The callback in the extending class.
     * @param array     $defaults   [optional] An array of default attributes.
     */
    public function __construct($code, callable $callback, array $defaults = [])
    {
        $this->code = $code;
        $this->callback = $callback;
        $this->defaults = $defaults;
    }

    /**
     * Function called by Wordpress when a shortcode is used.
     *
     * @param array     $atts       A key => value list of attributes the editor specified.
     * @param string    $content    The [shortcode]content[/shortcode] the editor specified.
     * @param string    $tag        The name of the shortcode used.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function callback($atts, $content, $tag)
    {
        if ($tag !== $this->code) {
            throw new \Exception("Wrong callback registered for shortcode [{$tag}].");
        }
        $a = shortcode_atts($this->defaults, $atts, $this->code);
        return call_user_func($this->callback, $a, $content);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}