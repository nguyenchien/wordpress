<?php
/*
 * Template Name: Top Page
 */
?>
<?php get_header(); ?>
<div id="content">
    <div class="wrapper flex-box">
        <div class="main-content">
            <?php
                if(have_posts()){
                    while (have_posts()){
                        the_post();
                        the_content();
                    }
                }else{
                    get_template_part('content', 'none');
                }
            ?>
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
