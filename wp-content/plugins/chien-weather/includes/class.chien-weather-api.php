<?php
    // Chặn user truy xuất trực tiếp vào file
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    class Chien_Weather_API{
        // Get chuỗi json
        public static function get_JSON($json) {
            return json_decode($json, true);
        }

        /*
         * Gửi request lên API và get kết quả trả về
        */
        public static function request($city_id = 1566083, $mode = 'json') {
            // Template url search lấy từ API
            // http://api.openweathermap.org/data/2.5/forecast?id=1581130&APPID=b9381a07b4b8dbbe828cf7c3b41f604d
            $url = "http://api.openweathermap.org/data/2.5/forecast?id={$city_id}&APPID=b9381a07b4b8dbbe828cf7c3b41f604d";

            /*
             * Truy cập vào url và get file xuống
             * @: Không thông báo khi có lỗi
            */
            @$fget = file_get_contents($url);
            if($fget){
                return self::get_JSON($fget);
            }
            return false;
        }

        /*
         * Get dữ liệu weather
         * HN: 1581130
         * Hue: 1580240
         * HCM: 1566083
        */
        public static function get_weather($data = [], $mode = 'json') {
            if ($data) {
                // Tạo mảng hứng kết quả
                $return = [];

                // Duyệt mảng các thành phố (Hà Nội, Đà Nẵng, TP.Hồ Chí Minh)
                foreach ($data as $city_id) {
                    //http://api.openweathermap.org/data/2.5/weather?id=1581130&APPID=b9381a07b4b8dbbe828cf7c3b41f604d
                    $url = "http://api.openweathermap.org/data/2.5/weather?id={$city_id}&APPID=b9381a07b4b8dbbe828cf7c3b41f604d";
                    @$fget = file_get_contents($url);
                    if($fget){
                        $return[] = self::get_JSON($fget);
                    }
                }

                // Trả về list mảng các thành phố (mỗi tp là 1 mảng)
                if ($return) {
                    return $return;
                }
            }
            // Nếu không có data thì return false
            return false;
        }

        // Get dữ liệu nhiệt độ
        public static function get_temperature($temp = 0, $option = 'celsius') {
            switch ($option) {
                case 'celsius':
                    return $temp . 'C';
                    break;
                case 'fahrenheit':
                    return ($temp + (9/5) + 32) . 'F';
                    break;
            }
        }

        // Get icon
        public static function get_weather_icon($code = '01d') {
            return "http://openweathermap.org/img/w/{$code}.png";
        }
    }