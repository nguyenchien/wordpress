<?php
/*
 * Template Name: Full Width
 */
?>
<?php get_header(); ?>
<?php if(function_exists('bcn_display') && !is_front_page()){ ?>
    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
        <?php bcn_display(); ?>
    </div>
<?php } ?>
    <div id="content">
        <div class="wrapper flex-box">
            <div class="main-content main-content-full">
                <?php
                    if(have_posts()){
                        while (have_posts()){
                            the_post();
                            the_content();
                        }
                    }
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>