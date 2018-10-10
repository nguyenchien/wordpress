<?php
    // Chặn user truy xuất trực tiếp vào file
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    class Chien_Weather_Setting {
        protected $option;
        protected $option_group = 'tp_weather_group';

        public function __construct() {
            // Load setting
            $this->option = get_option('chien_weather_setting');

            // Add menu vào
            add_action('admin_menu', function(){
                add_submenu_page(
                    'options-general.php',
                    'Chien Weather Settings',
                    'Chien Settings',
                    'manage_options',
                    'chien_weather',
                    [$this, 'create_page']
                );
            });

            // Thêm hook admin_init
            add_action('admin_init', [$this, 'register_setting']);

            // Thêm js
            add_action('admin_enqueue_scripts', function (){
                wp_register_script('chien-weather-js', CHIEN_WEATHER_PLUGIN_URL . 'scripts/js/functions.js', ['jquery']);
                // Truyền dữ liệu bằng ajax
                wp_localize_script('chien-weather-js', 'chien', [
                    'url' => admin_url('admin-ajax.php')
                ]);
                wp_enqueue_script('chien-weather-js');
            });

            // Đăng ký ajax vào WP
            add_action('wp_ajax_search_city_ajax', [$this, 'search_city_ajax']);

        }

        // Create page
        public function create_page() {
            $option_group = $this->option_group;
            require (CHIEN_WEATHER_PLUGIN_PATH . 'views/chien-weather-setting.php');
        }

        public function register_setting() {
            register_setting(
                $this->option_group,
                'chien_weather_setting',
                [$this, 'save_setting']
            );
        }

        public function save_setting($input) {
            $new_input = [];
            if (isset($input['city_name']) && !empty($input['city_name'])) {
                foreach ($input['city_name'] as $value) {
                    $new_input['city_name'][] = urlencode(trim($value));
                }
            } else {
                $new_input['city_name'][] = 'Ho+Chi+Minh';
            }
            return $new_input;
        }

        public function search_city_ajax() {
            if (isset($_POST['city']) && !empty($_POST['city'])) {
                $data = Chien_Weather_API::request($_POST['city']);
                wp_send_json_success($data);
            }
        }
    }