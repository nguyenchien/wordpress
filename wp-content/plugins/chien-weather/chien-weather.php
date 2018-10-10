<?php
    /*
    Plugin Name: Chien Weather
    Plugin URI: http://chiennguyen.vn/plugin
    Description: Simple Plugin Weather
    Version: 1.0.0
    Author: Chien Nguyen
    Author URI: http://chiennguyen.vn
    Text Domain: chiennguyen
    */

    // Định nghĩa hằng số đường dẫn
    define('CHIEN_WEATHER_VERSION', '1.0.0');
    define('CHIEN_WEATHER_MINIUM_WP_VERSION', '4.1.1');
    define('CHIEN_WEATHER_PLUGIN_URL', plugin_dir_url(__FILE__));
    define('CHIEN_WEATHER_PLUGIN_PATH', plugin_dir_path(__FILE__));

    // Chặn user truy xuất trực tiếp vào file
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    // Include các files class cho widget
    require_once (CHIEN_WEATHER_PLUGIN_PATH . 'includes/class.chien-weather-setting.php');
    require_once (CHIEN_WEATHER_PLUGIN_PATH . 'includes/class.chien-weather-api.php');
    require_once (CHIEN_WEATHER_PLUGIN_PATH . 'includes/class.chien-weather-widget.php');
    require_once (CHIEN_WEATHER_PLUGIN_PATH . 'includes/class.chien-weather.php');

    // Tạo đối tượng cho class "ChienWeather" (trong file class.chien-weather.php)
    $chien_weather = new Chien_Weather();

//    echo "<pre>";
//    print_r(Chien_Weather_API::get_weather([1581130, 1580240, 1566083]));
//    echo "</pre>";
//    die;