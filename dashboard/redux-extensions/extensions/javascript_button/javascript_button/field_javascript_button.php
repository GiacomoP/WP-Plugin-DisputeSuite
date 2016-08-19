<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ReduxFramework_javascript_button')) {
    class ReduxFramework_javascript_button
    {
        public function __construct($field = [], $value ='', $parent)
        {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if (empty($this->extension_dir)) {
                $this->extension_dir = trailingslashit(str_replace( '\\', '/', dirname( __FILE__ )));
                $this->extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->extension_dir));
            }

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = [
                'options' => [],
                'stylesheet' => '',
                'output' => true,
                'enqueue' => true,
                'enqueue_frontend' => true
            ];
            $this->field = wp_parse_args($this->field, $defaults);
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings.
         */
        public function render()
        {
            echo <<<EOD
<a href="javascript:void(0);" class="button-primary">{$this->field['button_text']}</a>
EOD;
        }
    }
}