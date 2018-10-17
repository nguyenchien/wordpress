<?php
    // Get min price
    $minPrice = 0;
    if ( !empty($_GET['minPrice']) ) {
        $minPrice = $_GET['minPrice'];
    }

    // Get max price
    $maxPrice = 9999;
    if ( !empty($_GET['maxPrice']) ) {
        $maxPrice = $_GET['maxPrice'];
    }

    // Get kich thuoc
    $kichThuoc = '';
    if ( !empty($_GET['size']) ) {
        $kichThuoc = $_GET['size'];
    }

    // Get mau sac
    $mauSac = '';
    if ( !empty($_GET['color']) ) {
        $mauSac = $_GET['color'];
    }
?>
<div class="wrap-multi-search">
    <h3 class="title">WordPress Custom Query - Custom Filters</h3>
    <form action="<?php the_permalink(); ?>" method="get">
        <label>Giá từ:</label>
        <input type="number" name="minPrice" value="<?= $minPrice; ?>">

        <label>đến:</label>
        <input type="number" name="maxPrice" value="<?= $maxPrice; ?>">

        <label>Kích thước:</label>
        <select name="size">
            <option value="">Bất kỳ</option>
            <option value="nho">Nhỏ</option>
            <option value="vua">Vừa</option>
            <option value="lon">Lớn</option>
        </select>

        <label>Màu sắc:</label>
        <select name="color">
            <option value="">Bất kỳ</option>
            <option value="xanh">Xanh</option>
            <option value="vang">Vàng</option>
            <option value="do">Đỏ</option>
        </select>
        <button type="submit" name="">Filter</button>
    </form>
</div>

<?php
    // Query post
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'date',
        'meta_query' => array(
            //'relation' => 'OR',
            array(
                'key' => 'gia',
                'value' => array($minPrice, $maxPrice),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN'
            ),
            array(
                'key' => 'kich_thuoc',
                'value' => $kichThuoc,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'mau_sac',
                'value' => $mauSac,
                'compare' => 'LIKE'
            ),
        )
    );
    $my_query =  new WP_Query($args);
?>

<div class="wrap-condition-search">
    <?php
        $arrSize = array(
            'nho' => 'Nhỏ',
            'vua' => 'Vừa',
            'lon' => 'Lớn'
        );
        $arrColor = array(
            'xanh' => 'Xanh',
            'vang' => 'Vàng',
            'do' => 'Đỏ'
        );
    ?>
    <h3 class="title">Condition Search</h3>
    <ul>
        <li><strong>Giá thấp nhất</strong>: <?= !empty($_GET['minPrice']) ? $_GET['minPrice'] . ' vnd' : 'Bất kỳ' ?></li>
        <li><strong>Giá nhỏ nhất</strong>: <?= !empty($_GET['maxPrice']) ? $_GET['maxPrice'] . ' vnd' : 'Bất kỳ' ?></li>
        <li><strong>Kích thước</strong>: <?= !empty($_GET['size']) ? $arrSize[$_GET['size']] : 'Bất kỳ' ?></li>
        <li><strong>Màu sắc</strong>: <?= !empty($_GET['color']) ? $arrColor[$_GET['color']] : 'Bất kỳ' ?></li>
    </ul>
</div>

<div class="wrap-multi-search wrap-multi-search-result">
    <?php if ( $my_query->have_posts() ) : ?>
        <h3 class="title">Result:</h3>
        <p class="notice">Có <strong><?= $my_query->found_posts; ?></strong> kết quả được tìm thấy</p>
        <ul class="list-posts">
            <?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
            <li class="post">
                <h4 class="title-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p class="price"><strong>Giá</strong>: <?php if ( get_field('gia') ) the_field('gia'); ?> vnđ</p>
                <?php
                    $kich_thuoc = get_field_object('kich_thuoc');
                    $valueKT = $kich_thuoc['value'];
                    $labelKT = 'Chưa chọn';
                    if (array_key_exists($valueKT, $kich_thuoc['choices'])) {
                        $labelKT = $kich_thuoc['choices'][$valueKT];
                    }

                    $mau_sac = get_field_object('mau_sac');
                    $valueMS = $mau_sac['value'];
                    $labelMS = 'Chưa chọn';
                    if (array_key_exists($valueMS, $mau_sac['choices'])) {
                        $labelMS = $mau_sac['choices'][$valueMS];
                    }
                ?>
                <p class="size"><strong>Kích thước</strong>: <?php echo $labelKT; ?></p>
                <p class="size"><strong>Màu sắc</strong>: <?php echo $labelMS; ?></p>
            </li>
            <?php endwhile; ?>
        </ul>
        <div class="paging"><?php wp_pagenavi(array('query' => $my_query)); ?></div>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div>