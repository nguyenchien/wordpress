<?php
class Zendvn_Sp_Category_Validate {
    public function __construct() {
    }

    /*
     * Hiển thị dữ liệu của 1 table trong DB
     * $wpdb: là đối tượng của WP
     */
    public function test() {
        global $wpdb;
        echo __METHOD__ . '<br>';
    }
}