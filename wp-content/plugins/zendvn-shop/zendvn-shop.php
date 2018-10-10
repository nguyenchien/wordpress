<?php
/*
    Plugin Name: ZendVN Shopping
    Plugin URI: http://zend.vn
    Description: Simple Plugin Shopping Cart
    Version: 1.0
    Author: ZendVN Group
    Author URI: http://zend.vn
    Text Domain: chiennguyen
*/

/*
 * Nhúng file 'define.php' vào
*/
require_once 'define.php';

/*
 * Nhúng file 'includes/Controller.php' vào
 * Tạo đối tượng của class 'zController'
 * Biến $zController là biến TOÀN CỤC (vì nó được sử dụng rất nhiều nơi)
*/
require_once ZENDVN_SP_INCLUDE_PATH . DS . 'Controller.php';
global $zController;
$zController = new zController();

/*
 * Nhúng file 'backend.php' và 'frontend.php' vào
*/
if (is_admin()) {
    require_once 'backend.php';

    // Khởi tạo đối tượng của class 'Zendvn_Sp_Backend'
    new Zendvn_Sp_Backend();
} else {
    require_once 'frontend.php';

    // Khởi tạo đối tượng của class 'Zendvn_Sp_Frontend'
    new Zendvn_Sp_Frontend();
}