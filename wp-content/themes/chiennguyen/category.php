<?php get_header(); ?>
    <div id="content">
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