<?php
    // Chặn user truy xuất trực tiếp vào file
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    class Chien_Weather{
        public function __construct(){
            // Khởi tạo đối tượng cho class "Chien_Weather_Widget"
            $chien_weather_widget = new Chien_Weather_Widget();

            // Khởi tạo đối tượng cho class "Chien_Weather_Setting"
            $chien_weather_setting = new Chien_Weather_Setting();
        }

        public function activation_hook(){
        }

        public function deactivation_hook(){
        }
    }