<?php
    global $post;
?>
<?php foreach ($sale_posts as $sale_post): ?>
    <article id="<?= $sale_post->ID; ?>">
        <div class="entry-header">
            <h3 class="entry-title">
                <a href="/wordpress/<?= LANGUAGE; ?>/products_on_sale/<?= $sale_post->post_name; ?>" title="<?= $sale_post->post_title; ?>"><?= $sale_post->post_title; ?></a>
                <?php if(get_field('time_sale', $sale_post->ID)): ?>
                    <span class="time-sale"><?php the_field('time_sale', $sale_post->ID); ?></span>
                <?php endif; ?>
            </h3>
            <?php
                echo "<div class='entry-meta'>";
                printf('<span class="author">'.__('[:en]Posted by[:vi]Đăng bởi').': <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">%1s</a></span>', get_the_author());
                printf('<span class="date"> | '.__('[:en]at[:vi]vào lúc').': %1s</span>', get_the_date());
                printf('<span class="cate"> | '.__('[:en]in[:vi]Danh mục').': %1s </span>', get_the_term_list($sale_post->ID, 'products_on_sale_tax', ' ', ', ') );
                if(comments_open()){
                    echo "<span class='meta-reply'> | ";
                    comments_popup_link( 'Leave a comment', '1 comment', '% comments', 'comments-link', 'Comments are off for this post');
                    echo "</span>";
                }
                echo "</div>";
            ?>
        </div>
        <div class="entry-content entry-content-list">
            <?php if(has_post_thumbnail($sale_post->ID)): ?>
                <div class="post-thumb">
                    <?php echo get_the_post_thumbnail($sale_post->ID);?>
                </div>
            <?php endif; ?>
            <div class="post-content">
                <?php echo $sale_post->post_content; ?>
            </div>
        </div>
    </article>
<?php endforeach; ?>