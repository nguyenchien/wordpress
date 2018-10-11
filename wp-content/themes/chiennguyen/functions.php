<?php
/*======================================================================================================================
 * Khai báo hằng giá trị
 =====================================================================================================================*/
// Get đường dẫn tương đối
define('THEME_PATH', get_stylesheet_directory());

// Get đường dẫn tuyệt đối
define('THEME_URL', get_stylesheet_directory_uri());

// Đường dẫn đến thư mục /core
define('CORE_PATH', THEME_PATH . '/core');

// Get locale của qtranslate
define('LANGUAGE', get_locale());

/*=====================================================================================================================
* Detect environment by $is_production
* true: là môi trường product
* false: là môi trường dev
=====================================================================================================================*/
$is_production = true;
if(!$is_production && !is_user_logged_in()){
    echo "<div style='height:100%; overflow: hidden;' class='coming-soon'>";
    echo "<img style='width:100%;height:100%;' src='".THEME_URL."/images/coming-soon.jpg'>";
    echo "</div>";
    die;
}

/*=====================================================================================================================
 * Khai báo biến toàn cục
=====================================================================================================================*/
global $custom_links;
$custom_links = array('hello', 'product');

 /*=====================================================================================================================
  * Khai báo chức năng của theme support sẵn.
 =====================================================================================================================*/
 if(!function_exists('chiennguyen_theme_setup')){
     // khai báo hàm chiennguyen_theme_setup
     function chiennguyen_theme_setup(){
         // Tự động thêm RSS lên thẻ <head>
         add_theme_support('automatic-feed-links');

         // Thêm hình ảnh đại diện cho post (giống Featured Image của page)
         add_theme_support('post-thumbnails');

         // Thêm chức năng post format cho post
         add_theme_support('post-formats', array(
             'image',
             'video',
             'gallery',
             'quote',
             'link',
         ));

         // Tự động thêm tag title cho theme (nên khỏi thêm tag title trong header)
         add_theme_support('title-tag');

         // Set background mặc định và cho phép đổi màu background của theme
         $default_background = array(
             'default-color' => '#e8e8e8'
         );
         add_theme_support('custom-background', $default_background);

         // Đăng ký menu cho theme (quan trọng)
         register_nav_menu('primary', 'Primary Menu');

         // Add tag for custom post type
         register_taxonomy('tag','products_on_sale',array('post_tag'));

         // Add excerpt for page
         add_post_type_support( 'page', 'excerpt' );
     }
     // Load tự động hàm chiennguyen_theme_setup khi WP chạy.
     add_action('init', 'chiennguyen_theme_setup');
 }

/*=====================================================================================================================
 * ĐĂNG KÝ THÊM các sidebar cho theme.
 * Gọi sidebar ở các file template WordPress, pages template
=====================================================================================================================*/
add_action('widgets_init', 'chiennguyen_sidebar');
function chiennguyen_sidebar(){
    $recent_post_sidebar = array(
        'name' => 'Recent Post Sidebar',
        'id' => 'recent-post-sidebar',
        'description' => 'Recent Post Sidebar',
        'class' => 'recent-post-sidebar',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        'before_widget' => '<div class="wrap-item">',
        'after_widget'  => '</div>',
    );
    register_sidebar($recent_post_sidebar);

    $weather_sidebar = array(
        'name' => 'Weather Sidebar',
        'id' => 'weather-sidebar',
        'description' => 'Weather Sidebar',
        'class' => 'weather-sidebar',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    );
    register_sidebar($weather_sidebar);
}

/*=====================================================================================================================
 * Nhúng file css, js vào theme
=====================================================================================================================*/
add_action('wp_enqueue_scripts', 'chiennguyen_style');
function chiennguyen_style(){
    // Font awesome style
    wp_register_style('font-awesome-style', THEME_URL.'/css/font-awesome.css', 'chiennguyen');
    wp_enqueue_style('font-awesome-style');

    // Reset css style
    wp_register_style('reset-style', THEME_URL.'/css/reset.css', 'chiennguyen', time());
    wp_enqueue_style('reset-style');

    // Main style default
    wp_register_style('main-style', THEME_URL.'/style.css', 'chiennguyen', time());
    wp_enqueue_style('main-style');

    // Custom script
    wp_register_script('my-script', THEME_URL.'/js/my-script.js', array('jquery'), time());
    wp_enqueue_script('my-script');
}

 /*=====================================================================================================================
  * Khai báo chức năng customize cho theme
 =====================================================================================================================*/
// Custom excerpt_more cho page
function chiennguyen_readmore(){
    return " ... <a href='".get_the_permalink(get_the_ID())."' class='read-more'>Read more</a>";
}
add_filter('excerpt_more', 'chiennguyen_readmore');

/*=====================================================================================================================
 * Khai báo shortcode
=====================================================================================================================*/
/*
 * Thêm shortcode [base_url] cho content
 * Using: [base_url]
 */
add_shortcode( 'base_url', 'base_url_func' );
function base_url_func() {
    ob_start();
    echo THEME_URL;
    return ob_get_clean();
}

//add_filter( 'the_content', 'filterTheContent' );
//function filterTheContent($content) {
//    return str_replace('[base_url]', THEME_URL, $content);
//}

/*
 * Get all posts with post_type: products_on_sale
 * Using: [product_on_sale limit=3]
 */
add_shortcode( 'product_on_sale', 'product_on_sale_func' );
function product_on_sale_func($atts) {
    $atts_shortcode = shortcode_atts(array(
        'limit' => -1,
    ), $atts);

    $args = array(
        'post_status' => 'publish',
        'post_type' => 'products_on_sale',
        'posts_per_page' => $atts_shortcode['limit'],
        'order' => 'DESC',
        'orderby' => 'date',
    );
    $the_query  = new WP_Query($args);
    $sale_posts = $the_query->get_posts();

    ob_start();
    include(locate_template('inc/item.php'));
    return ob_get_clean();
}

/*=====================================================================================================================
 * Rewrite url for search
 * Ví dụ: khi search từ khóa: product, hello ở textbox search => địa chỉ trên url sẽ có dạng: ?s=product, ?s=hello
 * Yêu cầu: khi gõ /product, /hello trên url thì vẫn ra kết quả tương tự
 * page/2/?s=product (search khi có phân trang, vị trí dòng này PHẢI nằm trước)
 * ?s=product (search khi không có phân trang, vị trí nằm sau)
 *
=====================================================================================================================*/
// Custom url
add_filter('rewrite_rules_array', 'mmp_rewrite_rules');
function mmp_rewrite_rules($rules){
    $newRules  = array();
    $newRules['^custom/(.+)/page/?([0-9]{1,})/?$'] = 'index.php?s=$matches[1]&paged=$matches[2]';
    $newRules['^custom/(.+)$'] = 'index.php?s=$matches[1]';
    return array_merge($newRules, $rules);
}

// Custom search filter
add_action('pre_get_posts','search_filter');
function search_filter($query) {
    if ( !is_admin() && $query->is_main_query() ) {
        if ($query->is_search) {
            $search_query = get_search_query();
            $post_type = get_query_var('post_type');
            if (isset($post_type)) {
                if ($post_type == 'post') {
                    $slugs_column_simple = array(
                        'homongi'=>'訪問着', 'tomesode'=>'留袖', 'furisode'=>'振袖', 'hakama'=>'袴', 'mofuku'=>'喪服', 'yukata'=>'浴衣',
                        'obi'=>'帯', 'men'=>'男性',
                        'wedding'=>'結婚', 'coming-of-age'=>'成人', 'shrine-visit-for-birth'=>'宮参り',
                    );
                    $slugs_column_multi = array('ubugi','kitsuke','komono','hair-style','graduation','enter-school','753','other');
                    if (array_key_exists($search_query, $slugs_column_simple)) {
                        foreach ($slugs_column_simple as $k => $v){
                            if($search_query == $k){
                                $query->set('s', $v);
                                break;
                            }
                        }
                    } elseif (in_array($search_query, $slugs_column_multi)){
                        foreach ($slugs_column_multi as $v){
                            if($search_query === $v){
                                $query->set('s', ''); // chưa hiểu chổ này
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}

/*
 * Trường hợp: search multi key và exclude key
 * Lưu ý: biểu thức của where, mở đầu bằng 3 dấu '(' và kết thúc bằng 3 dấu ')'
 */
add_filter( 'posts_where', 'swe_posts_where', 10, 2 );
function swe_posts_where( $where, $query ){
    if ( !is_admin() && $query->is_main_query() ) {
        if ($query->is_search) {
            $post_type = get_query_var('post_type');
            $slugs_column_multi = array('ubugi','kitsuke');
            $uri = $_SERVER['REQUEST_URI'];
            global $table_prefix;
            if ( isset($post_type) && $post_type == 'post') {
                $key_search = $query->query['s'];
                if (!empty($key_search)) {
                    if (in_array($key_search, $slugs_column_multi)) {
                        foreach ($slugs_column_multi as $v) {
                            if (strpos($uri, $v) !== false && $v == 'ubugi') {
                                $table_posts = $table_prefix.'posts';
                                // searched by keyword 産着 OR 初着 /ubugi
                                $mywhere = " ((($table_posts.post_title LIKE '%産着%') OR ($table_posts.post_excerpt LIKE '%産着%') OR ($table_posts.post_content LIKE '%産着%')) ";
                                $mywhere .= " OR (($table_posts.post_title LIKE '%初着%') OR $table_posts.post_excerpt LIKE '%初着%') OR ($table_posts.post_content LIKE '%初着%'))) ";
                            } elseif (strpos($uri, $v) !== false && $v == 'kitsuke') {
                                $table_posts = $table_prefix.'posts';
                                // searched by keyword 着付け OR 着方 /kitsuke
                                $mywhere = " ((($table_posts.post_title LIKE '%着付け%') OR ($table_posts.post_excerpt LIKE '%着付け%') OR ($table_posts.post_content LIKE '%着付け%')) ";
                                $mywhere .= " OR (($table_posts.post_title LIKE '%着方%') OR ($table_posts.post_excerpt LIKE '%着方%') OR ($table_posts.post_content LIKE '%着方%'))) ";
                            }
                        }
                    } elseif ($key_search == 'kimono') {
                        $table_posts = $table_prefix.'posts';
                        // searched by exclude keyword 浴衣 /kimono
                        $mywhere = " ((($table_posts.post_title NOT LIKE '%浴衣%') AND ($table_posts.post_excerpt NOT LIKE '%浴衣%') AND ($table_posts.post_content NOT LIKE '%浴衣%'))) ";
                    }
                }
            }
            if(!empty($mywhere)){
                if( '' != $where ) {
                    $where .= ' AND'.$mywhere;
                } else {
                    $where .= ' '.$mywhere;
                }
            }
        }
    }
    return $where;
}

// Custom seo title
add_filter('wpseo_title', 'swe_filter_wpseo_title');
function swe_filter_wpseo_title($title) {
    if(  is_search() ) {
        global $custom_links, $paged;
        $uri = $_SERVER['REQUEST_URI'];
        foreach($custom_links as $v){
            if(strpos($uri, $v) !== false){
                $title = __('Title ' . $v, 'chiennguyen');
                if (is_paged()) {
                    if ($paged >= 2) {
                        $title = __('Title ' .$v . ' - page ' . $paged, 'chiennguyen');
                    }
                }
            }
        }
    }
    return $title;
}

// Custom seo description
function swe_filter_wpseo_metadesc( $desc ) {
    if(  is_search() ) {
        global $custom_links, $paged;
        $uri = $_SERVER['REQUEST_URI'];

        foreach($custom_links as $v){
            if(strpos($uri, $v) !== false){
                $desc = __('Description ' . $v, 'chiennguyen');
                if (is_paged()) {
                    if ($paged >= 2) {
                        $desc = __('Description ' .$v . ' - page ' . $paged, 'chiennguyen');
                    }
                }
            }
        }
    }
    return $desc;
}
add_filter( 'wpseo_metadesc', 'swe_filter_wpseo_metadesc', 10, 1 );

// Custom title top page for breadcrumbs
add_filter('bcn_breadcrumb_title', function($title, $type, $id) {
    if ($type[0] === 'home') {
        $title = get_the_title(get_option('page_on_front'));
    }
    return $title;
}, 42, 3);

/*=======================================================================================
    Create gallery for single post
 ========================================================================================*/
// Remove shortcode [gallery] in content
function strip_shortcode_gallery($content) {
    preg_match_all( '/'. get_shortcode_regex().'/s', $content, $matches, PREG_SET_ORDER);
    if (!empty($matches)) {
        foreach($matches as $shortcode ) {
            if ('gallery' === $shortcode[2]) {
                $pos = strpos($content, $shortcode[0]);
                if(false !== $pos) {
                    $content = substr_replace($content, '', $pos, strlen($shortcode[0]));
                }
            }
        }
    }
    return $content;
}

// Get info post gallery
function get_post_gallery_images_with_info($postvar = NULL) {
    if(!isset($postvar)){
        global $post;
        $postvar = $post; //if the param wasnt sent
    }

    $post_content = $postvar->post_content;
    preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
    $images_id = explode(",", $ids[1]); //we get the list of IDs of the gallery as an Array

    $image_gallery_with_info = array();
    //we get the info for each ID
    foreach ($images_id as $image_id) {
        $attachment = get_post($image_id);
        array_push($image_gallery_with_info, array(
                'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                'caption' => $attachment->post_excerpt,
                'description' => $attachment->post_content,
                'href' => get_permalink($attachment->ID),
                'src' => $attachment->guid,
                'title' => $attachment->post_title
            )
        );
    }
    return $image_gallery_with_info;
}