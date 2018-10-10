<?php get_header(); ?>
    <div id="content">
        <div class="search-info">
            <?php
                global $wp_query;
                $total_results = $wp_query->found_posts;
            ?>
            <b><?php _e('[:en]There are[:vi]Có'); ?> <?php echo $total_results; ?> <?php _e('[:en]result found.[:vi]kết quả được tìm thấy.'); ?></b>
        </div>
        <div class="wrapper flex-box">
            <div class="main-content">
                <?php
                    if(have_posts()){
                        while (have_posts()){
                            the_post();
                            get_template_part('content', get_post_format());
                        }
                    }else{
                        get_template_part('content', 'none');
                    }
                ?>
                <div class="paging"><?php wp_pagenavi(); ?></div>
            </div>
            <div class="sidebars">
                <div class="sidebar">
                    <?php get_sidebar(); ?>
                </div>
                <div class="sidebar">
                    <?php get_sidebar('recent-post'); ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>