<?php get_header(); ?>
    <div id="content">
        <div class="wrapper flex-box">
            <div class="main-content">
                <p class="note-404">Not found. Please try again!</p>
                <div class="image-404">
                    <img src="<?php echo THEME_URL; ?>/images/404-not-found.png" alt="">
                </div>
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