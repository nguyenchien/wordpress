<?php
/*
 * Thực hiện các chức năng trong admin
 */
class Zendvn_Sp_Backend {
    private $_menuSlug = 'zendvn-sp-manager';
    private $_page = '';

    public function __construct() {
        // Get biến 'page' trên url
        if (isset($_GET['page'])) {
            $this->_page = $_GET['page'];
        }

        // Add hàm 'menus' vào hook 'admin_menu'
        add_action('admin_menu', array($this, 'menus'));
    }

    /*
     * Xây dựng hệ thống menus
     * - ZShopping
     *  + Dashboard
     *  + Categories (dùng Custom Taxonomy)
     *  + Products (dùng Custom Post Type)
     *  + Manufacturer
     *  + Invoices
     *  + Settings
     */
    public function menus() {
        // Menu cha
        add_menu_page('ZShopping', 'ZShopping', 'manage_options', $this->_menuSlug, array($this, 'dispatch_function'), '', 3);

        // Menu con
        add_submenu_page($this->_menuSlug, 'Categories', 'Categories', 'manage_options', $this->_menuSlug.'-categories', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'Products', 'Products', 'manage_options', $this->_menuSlug.'-products', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'Manufacturer', 'Manufacturer', 'manage_options', $this->_menuSlug.'-manufacturer', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'Invoices', 'Invoices', 'manage_options', $this->_menuSlug.'-invoices', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'Settings', 'Settings', 'manage_options', $this->_menuSlug.'-settings', array($this, 'dispatch_function'));
    }

    // Điều hướng menus
    public function dispatch_function() {
        /*
         * Gọi biến toàn cục '$zController'
         * Được khai báo ở file: 'zendvn-shop.php'
         * Source class: 'includes/Controller.php'
        */
        global $zController;

        // Get biến '$_page'
        $page = $this->_page;

        // Nhúng file class '/backend/AdminShopping.php' vào
        if ($page == 'zendvn-sp-manager') {
            /*
             * Nhúng file '/controllers/backend/AdminShopping.php' vào
             * Tạo đối tượng của class 'Zendvn_Sp_AdminShopping_Controller'
             * ========================================================================================
             * require_once ZENDVN_SP_CONTROLLER_PATH . DS . 'backend' . DS . 'AdminShopping.php';
             * $obj = new Zendvn_Sp_AdminShopping_Controller();
             * ========================================================================================
             * NOTE: Cách này đúng nhưng chưa perfect, chưa linh động, vì còn nặng hardcode.
             * => Giải pháp:
             *  + Sẽ load file tự động với 2 tham số truyền vào (thư mục 'backend' và file 'AdminShopping.php')
             *  + Viết trong files '/includes/Controller' và trong hàm 'getController()'
            */

            // Tạo đối tượng của class 'Zendvn_Sp_AdminShopping_Controller'
            $obj = $zController->getController('AdminShopping', '/backend');
            $obj->display();
        }

        // Nhúng file class '/backend/AdminCategory.php' vào
        if ($page == 'zendvn-sp-manager-categories') {
            // Tạo đối tượng của class 'Zendvn_Sp_AdminCategory_Controller'
            $obj = $zController->getController('AdminCategory', '/backend');
            $obj->display();
        }

        // Nhúng file class '/backend/AdminProduct.php' vào
        if ($page == 'zendvn-sp-manager-products') {
            // Tạo đối tượng của class 'Zendvn_Sp_AdminProduct_Controller'
            $obj = $zController->getController('AdminProduct', '/backend');
            $obj->display();
        }

        // Nhúng file class '/backend/AdminManufacturer.php' vào
        if ($page == 'zendvn-sp-manager-manufacturer') {
            // Tạo đối tượng của class 'Zendvn_Sp_AdminManufacturer_Controller'
            $obj = $zController->getController('AdminManufacturer', '/backend');
            $obj->display();
        }

        // Nhúng file class '/backend/AdminInvoice.php' vào
        if ($page == 'zendvn-sp-manager-invoices') {
            // Tạo đối tượng của class 'Zendvn_Sp_AdminInvoice_Controller'
            $obj = $zController->getController('AdminInvoice', '/backend');
            $obj->display();
        }

        // Nhúng file class '/backend/AdminSetting.php' vào
        if ($page == 'zendvn-sp-manager-settings') {
            // Tạo đối tượng của class 'Zendvn_Sp_AdminSetting_Controller'
            $obj = $zController->getController('AdminSetting', '/backend');
            $obj->display();
        }
    }
}