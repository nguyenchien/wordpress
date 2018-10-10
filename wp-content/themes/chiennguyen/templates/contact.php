<?php
/*
 * Template Name: Contact
 */
?>
<?php get_header(); ?>
<div id="content">
    <?php if(function_exists('bcn_display') && !is_front_page()){ ?>
        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php bcn_display(); ?>
        </div>
    <?php } ?>
    <div class="wrapper flex-box">
        <div class="main-content">
            <?php
            if(have_posts()){
                while (have_posts()){the_post();
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
