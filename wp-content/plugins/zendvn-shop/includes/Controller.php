<?php
class zController {

    // Hàm khởi tạo
    public function __construct($options = array()) {
    }

    /*
     * Nhúng các tập tin nằm trong thư mục 'controllers/backend'
     * Tham số truyền vào:
     *  + $filename = 'AdminShopping'
     *  + $dir = '/backend'
     * Return: Hàm này sẽ trả về 1 đối tượng
     * Nên ta khai báo class 'new stdClass()' để hứng kết quả trả về
     * Mặc định class 'new stdClass()' sẽ trả về 1 đối tượng rỗng
    */
    public function getController($filename = '', $dir = '') {
        /*
         * Template nhúng file:
         * require_once ZENDVN_SP_CONTROLLER_PATH . '/backend' . DS . 'AdminShopping.php';
         * $obj = new Zendvn_Sp_AdminShopping_Controller();
         * Note: đúng nhưng chưa linh động, phải nhớ nhiều hằng số path
         * => Giải pháp: dùng phương thức 'getController()' sẽ linh động hơn.
         */

        // Tạo đối tượng rỗng để hứng kết quả trả về
        $obj = new stdClass();

        if (!empty($filename) && !empty($dir)) {
            // Nhúng file tương ứng trong thư mục '/controllers/backend' vào
            $file = ZENDVN_SP_CONTROLLER_PATH . $dir . DS . $filename . '.php';

            // Kiểm tra file nhúng vào có tồn tại không?
            if (file_exists($file)) {
                // Nếu file tồn tại => nhúng file vào
                require_once $file;

                /*
                 * Tạo đối tượng của class tương ứng trong thư mục 'controllers/backend'
                 * Lưu ý: dấu '()' PHẢI VIẾT CÁCH RA
                */
                $controllerName = ZENDVN_SP_PREFIX . $filename . '_Controller';
                $obj = new $controllerName ();
            }
        }
        return $obj;
    }

    /*
     * Nhúng các tập tin nằm trong thư mục 'models'
     * Template nhúng:
     * require_once ZENDVN_SP_MODEL_PATH . DS . 'Category.php';
     * $model = new Zendvn_Sp_Category_Model();
     * NOTE: đúng nhưng không perfect
     * => Giải pháp: viết trong hàm getModel()
     * Giống như getController() ở trên.
    */
    public function getModel($filename = '', $dir = '') {
        $obj = new stdClass();
        if (!empty($filename)) {
            $file = ZENDVN_SP_MODEL_PATH . $dir . DS . $filename . '.php';
            if (file_exists($file)) {
                require_once $file;
                $modelName = ZENDVN_SP_PREFIX . $filename . '_Model';
                $obj = new $modelName ();
            }
        }
        return $obj;
    }

    // Nhúng các tập tin nằm trong thư mục 'helpers'
    public function getHelper($filename = '', $dir = '') {
        $obj = new stdClass();
        if (!empty($filename)) {
            $file = ZENDVN_SP_HELPER_PATH . $dir . DS . $filename . '.php';
            if (file_exists($file)) {
                require_once $file;
                $helperName = ZENDVN_SP_PREFIX . $filename . '_Helper';
                $obj = new $helperName ();
            }
        }
        return $obj;
    }

    /*
     * Nhúng các tập tin tương ứng nằm trong thư mục 'templates'
     * Template: require_once ZENDVN_SP_TEMPLATE_PATH . DS . '/backend/shopping' . DS . 'display.php';
     * Note: đúng nhưng chưa linh động, phải nhớ nhiều hằng số path
     * => Giải pháp: dùng phương thức 'getView()' sẽ linh động hơn.
     * Tham số truyền vào:
     *  + $filename = 'display.php'
     *  + $dir = '/backend/shopping'
     * Return: 1 tập tin được kéo vào
    */
    public function getView ($filename = '', $dir = '') {
        if (!empty($filename) && !empty($dir)) {
            $file = ZENDVN_SP_TEMPLATE_PATH . $dir . DS . $filename;
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    // Nhúng các tập tin nằm trong thư mục 'validates'
    public function getValidate($filename = '', $dir = '') {
        $obj = new stdClass();
        if (!empty($filename)) {
            $file = ZENDVN_SP_VALIDATE_PATH . $dir . DS . $filename . '.php';
            if (file_exists($file)) {
                require_once $file;
                $validateName = ZENDVN_SP_PREFIX . $filename . '_Validate';
                $obj = new $validateName ();
            }
        }
        return $obj;
    }

    /*
     * Nhúng các tập tin nằm trong thư mục 'css'
     * Đường dẫn url lúc nào cũng là dấu '/'
     * => Nên ta không cần dùng hằng số 'DS'
     * Hàm get_headers() trả về 1 mảng:
     Array
        (
            [0] => HTTP/1.1 200 OK
            [1] => Date: Thu, 13 Sep 2018 07:01:53 GMT
            [2] => Server: Apache/2.4.7 (Ubuntu)
            [3] => Last-Modified: Thu, 13 Sep 2018 06:50:51 GMT
            [4] => ETag: "0-575bb20ae7824"
            [5] => Accept-Ranges: bytes
            [6] => Content-Length: 0
            [7] => Connection: close
            [8] => Content-Type: text/css
        )
     * Return: trả về đường dẫn của file css nếu nó tồn tại.
    */
    public function getCssUrl ($filename = '', $dir = '') {
        if (!empty($filename)) {
            $url = ZENDVN_SP_CSS_URL . $dir . '/' . $filename;
            $headers = @get_headers($url);
            $flag = strpos($headers[0], '200 OK') ? true : false;
            if ($flag == true) {
                return $url;
            }
        }
        return false;
    }

    /*
     * Nhúng các tập tin nằm trong thư mục 'js'
     * Return: trả về đường dẫn của file js nếu nó tồn tại.
    */
    public function getJsUrl ($filename = '', $dir = '') {
        if (!empty($filename)) {
            $url = ZENDVN_SP_JS_URL . $dir . '/' . $filename;
            $headers = @get_headers($url);
            $flag = strpos($headers[0], '200 OK') ? true : false;
            if ($flag == true) {
                return $url;
            }
        }
        return false;
    }

    /*
     * Nhúng các tập tin nằm trong thư mục 'images'
     * Return: trả về đường dẫn của file image nếu nó tồn tại.
    */
    public function getImageUrl ($filename = '', $dir = '') {
        if (!empty($filename)) {
            $url = ZENDVN_SP_IMAGES_URL . $dir . '/' . $filename;
            $headers = @get_headers($url);
            $flag = strpos($headers[0], '200 OK') ? true : false;
            if ($flag == true) {
                return $url;
            }
        }
        return false;
    }

}