<?php
    wp_enqueue_script('chien-script-flexslider', THEME_URL . '/js/jquery.flexslider.js');
    wp_register_style('chien-style-flexslider', THEME_URL . '/css/flexslider.css');
    wp_enqueue_style('chien-style-flexslider');

    global $post;

    // Get info gallery
    $gallery = get_post_gallery_images_with_info($post);

    // Remove shortcode in content
    $content = strip_shortcode_gallery(get_the_content());
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header">
        <h3 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            <?php if(get_field('time_sale')): ?>
                <span class="time-sale"><?php the_field('time_sale'); ?></span>
            <?php endif; ?>
        </h3>
        <?php
            // Kiểm tra cate hoặc post có nằm trong taxonomy (products_on_sale_tax) không?
            $post_in_tax = get_the_terms( $post->ID , 'products_on_sale_tax');

            if(!is_page()){
                echo "<div class='entry-meta'>";
                printf('<span class="author">'.__('Posted by', 'chiennguyen').': <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">%1s</a></span>', get_the_author());
                printf('<span class="date"> | '.__('at', 'chiennguyen').': %1s</span>', get_the_date());
                printf('<span class="cate"> | '.__('in', 'chiennguyen').': %1s </span>', ($post_in_tax) ? get_the_term_list($post->ID, 'products_on_sale_tax', ' ', ', ') : get_the_category_list(', ') );
                if(comments_open()){
                    echo "<span class='meta-reply'> | ";
                    comments_popup_link( __('Leave a comment', 'chiennguyen'), '1 '.__('comment', 'chiennguyen'), '% '.__('comment', 'chiennguyen'), 'comments-link', __('Comments are off for this post', 'chiennguyen'));
                    echo "</span>";
                }
                echo "</div>";
            }
        ?>
    </div>
    <div class="entry-content <?php echo !is_single() ? 'entry-content-list' : ''; ?>">
<!--        --><?php //if(has_post_thumbnail()): ?>
<!--            <div class="post-thumb">--><?php //the_post_thumbnail(); ?><!--</div>-->
<!--        --><?php //endif; ?>

        <div class="post-content">
            <?php if ( !is_single() ) : ?>
                <?php the_excerpt(); ?>
            <?php else : ?>
                <?php if ( !empty($gallery) ) : ?>
                <div class="wrap-flexslider">
                    <div id="slider" class="flexslider">
                        <ul class="slides">
                            <?php foreach ($gallery as $key => $item) : ?>
                                <li><img src="<?= $item['src']; ?>" alt=""><p class='flex-caption'><?= $item['description']; ?></p></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div id="carousel" class="photo-session-carousel flexslider">
                        <ul class="slides">
                            <?php foreach ($gallery as $key => $item) : ?>
                                <li><img src="<?= $item['src']; ?>" alt=""></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <?php echo $content; ?>
            <?php endif; ?>

            <?php
                if( is_single() ) {
                    if(has_tag()){
                        printf('<div class="tag-list"><b>'.__('Tagged in', 'chiennguyen').'</b>: %1s</div>', get_the_tag_list('',', '));
                    }
                }
            ?>
        </div>
    </div>
</article>

<script type="text/javascript">
    $(document).ready(function () {
        function isSmartPhone(){
            return ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)));
        }

        var containerWidth = $('#carousel').width();
        var marginWidth = 10;
        if(isSmartPhone()){
            var minItems = 3;
            var maxItems = 3;

        } else{
            var minItems = 4;
            var maxItems = 4;
        }
        var itemWidth = (containerWidth - marginWidth) / minItems;

        $('#carousel').flexslider({
            animation: "slide",
            controlNav: true,
            animationLoop: false,
            directionNav: true,
            slideshow: true,
            slideshowSpeed: 3000,
            asNavFor: '#slider',
            itemMargin: marginWidth,
            itemWidth: itemWidth,
            minItems: minItems,
            maxItems: maxItems
        });
        $('#slider').flexslider({
            animation: "slide",
            controlNav: true,
            directionNav: true,
            slideshowSpeed: 3000,
            animationLoop: false,
            slideshow: true,
            sync: "#carousel"
        });
    });
</script>
<style type="text/css">
    .wrap-flexslider{
        margin-bottom: 40px;
    }
    .wrap-flexslider .flexslider{
        margin-bottom: 10px;
        border: none;
        border-radius: 0;
    }
    .wrap-flexslider .flexslider .slides > li{
        position: relative;
    }
    .wrap-flexslider .flexslider .slides > li .flex-caption{
        position: absolute;
        width: 100%;
        margin-bottom: 0;
        padding: 10px;
        height: 40px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        text-align: center;
    }
    .wrap-flexslider .flex-direction-nav .flex-disabled {
        opacity: 1!important;
        cursor: pointer;
        z-index: 2;
    }
    .wrap-flexslider .flex-direction-nav .flex-next,
    .wrap-flexslider .flex-direction-nav .flex-prev {
        display: block;
        overflow: inherit;
    }
    .wrap-flexslider .flex-direction-nav .flex-next {
        text-indent: 9000px;
    }
    .wrap-flexslider .flex-direction-nav .flex-prev {
        text-indent: -9999px;
    }
    .wrap-flexslider .flex-direction-nav .flex-next:before,
    .wrap-flexslider .flex-direction-nav .flex-prev:before{
        position: absolute;
        top: 8px;
        left: 10px;
        content: "";
        width: 7px;
        height: 7px;
        border-right: 2px solid #000;
        border-top: 2px solid #000;
    }
    .wrap-flexslider .flex-direction-nav .flex-next:before {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        float: left;
        left: 6px;
    }
    .wrap-flexslider .flex-direction-nav .flex-prev:before {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        float: right;
    }
    .wrap-flexslider .flex-direction-nav a {
        background-color: rgba(255,255,255,.6);
        width: 25px;
        height: 25px;
        top: 60%;
    }
    .wrap-flexslider .flex-control-paging li a.flex-active{
        background: rgba(94, 31, 12, 1);
    }
    .wrap-flexslider #carousel img{
        opacity: .5;
        cursor: pointer;
    }
    .wrap-flexslider #carousel img:hover{
        opacity: 1;
    }
    .wrap-flexslider #carousel .flex-active-slide img {
        opacity: 1;
        cursor: default;
    }
    .wrap-flexslider .flex-pauseplay a{
        display: none;
    }
    .wrap-flexslider .flex-caption {
        width: 96%;
        padding: 2%;
        left: 0;
        bottom: 0;
        background: rgba(0,0,0,.5);
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0,0,0,.3);
        font-size: 14px;
        line-height: 18px;
    }
    .wrap-flexslider li.css a {
        border-radius: 0;
    }
    .wrap-flexslider .flexslider .slides img{
        margin: 0;
    }
</style>