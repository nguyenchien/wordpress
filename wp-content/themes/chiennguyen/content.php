<?php
    global $post;
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
        <?php if(has_post_thumbnail()): ?>
            <div class="post-thumb"><?php the_post_thumbnail(); ?></div>
        <?php endif; ?>
        <div class="post-content">
            <?php
                // Show excerpt, content for post
                if(!is_single()){
                    the_excerpt();
                }else{
                    the_content();
                }

                // Show list tags for post
                if(is_single()){
                    if(has_tag()){
                        printf('<div class="tag-list"><b>'.__('Tagged in', 'chiennguyen').'</b>: %1s</div>', get_the_tag_list('',', '));
                    }
                }
            ?>
        </div>
    </div>
</article>