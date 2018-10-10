<?php
    // Chặn user truy xuất trực tiếp vào file
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    class Chien_Weather_Widget extends WP_Widget {
        // Hiển thị widget trong wp-admin/widgets
        public function __construct() {
            parent::__construct (
                'chien-weather-widget', // ID widget
                __('Chien Weather Widget', 'chiennguyen'), // Name widget
                array( 'description' => __( 'Simple Widget Weather', 'chiennguyen' )) // Arguments widget
            );
            add_action('widgets_init', function (){
                register_widget('Chien_Weather_Widget');
            });

            // Đăng ký css cho plugin
            add_action('wp_enqueue_scripts', function (){
                wp_register_style('chien-weather-style', CHIEN_WEATHER_PLUGIN_URL . 'scripts/css/style.css');
                wp_enqueue_style('chien-weather-style');
            });
        }

        // Layout form cho widget, hiển thị trong admin
        public function form($instance) {
            // Get title
            $title = (isset($instance['title']) && !empty($instance['title'])) ? apply_filters('widget_title', $instance['title']) : __('Chien Weather Widget', 'chiennguyen');
            $unit = (isset($instance['unit']) && !empty($instance['unit'])) ? $instance['unit'] : 'celsius';
            require (CHIEN_WEATHER_PLUGIN_PATH . 'views/chien-weather-widget-form.php');
        }

        // Lưu thông tin khi update
        public function update($new_instance, $old_instance) {
            $instance = [];
            $instance['title'] = (isset($new_instance['title']) && !empty($new_instance['title'])) ? apply_filters('widget_title', $new_instance['title']) : __('Chien Weather Widget', 'chiennguyen');
            $instance['unit'] = (isset($new_instance['unit']) && !empty($new_instance['unit'])) ? $new_instance['unit'] : 'celsius';
            return $instance;
        }

        // layout hiển thị ra ngoài
        public function widget($args, $instance) {
            require (CHIEN_WEATHER_PLUGIN_PATH . 'views/chien-weather-widget-view.php');
        }
    }