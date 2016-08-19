<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ReduxFramework_extension_javascript_button')) {
    class ReduxFramework_extension_javascript_button
    {
        public $extension_url;
        public $extension_dir;
        protected $parent;
        public static $theInstance;

        public function __construct($parent)
        {
            $this->parent = $parent;
            if (empty($this->extension_dir)) {
                $this->extension_dir = trailingslashit(str_replace( '\\', '/', dirname(__FILE__ )));
            }
            $this->field_name = 'javascript_button';

            self::$theInstance = $this;

            add_filter('redux/'.$this->parent->args['opt_name'].'/field/class/'.$this->field_name, [&$this, 'overload_field_path']);
        }

        public function getInstance()
        {
            return self::$theInstance;
        }

        public function overload_field_path($field)
        {
            return dirname(__FILE__).'/'.$this->field_name.'/field_'.$this->field_name.'.php';
        }
    }
}