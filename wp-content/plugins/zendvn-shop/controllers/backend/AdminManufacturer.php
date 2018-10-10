<?php
class Zendvn_Sp_AdminManufacturer_Controller {
    public function __construct () {
    }

    public function display () {
        /*
         * Nhúng file 'templates/backend/manufacturer/display.php' vào
         * Template: require_once ZENDVN_SP_TEMPLATE_PATH . '/backend/manufacturer' . DS . 'display.php';
         * Note: đúng nhưng chưa linh động
         * => Giải pháp: dùng phương thức 'getView()' của class 'zController' sẽ linh động hơn.
         */
        global $zController;
        $zController->getView('display.php', '/backend/manufacturer');
    }
}