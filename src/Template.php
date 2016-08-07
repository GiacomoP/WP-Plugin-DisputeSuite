<?php

namespace DisputeSuite;

/**
 * Helper class to handle template files.
 */
class Template
{
    /**
     * Returns a template as a string.
     *
     * @param string    $file
     * @param mixed     $data [optional]
     *
     * @return string
     */
    public static function getAsString($file, $data = null)
    {
        if (!$data) {
            $data = [];
        }
        $template = [
            'imagesPath' => plugin_dir_url(dirname(__FILE__)) . 'assets/images'
        ];
        ob_start();
        require(plugin_dir_path(dirname(__FILE__)) . "templates/{$file}.php");
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}