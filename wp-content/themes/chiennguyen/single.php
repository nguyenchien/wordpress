<?php
    global $post;
    get_header();
?>
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
                    while (have_posts()){
                        the_post();
                        get_template_part('content', get_post_format());

                        $totalComments = wp_count_comments($post->ID)->total_comments;
                        if($totalComments > 0){

                            echo "<div id='comments' class='comments-item'><ul>";
                            $comments = get_comments(array(
                                'post_id'=>$post->ID,
                            ));
                            foreach($comments as $comment) :
                                echo("<li>
                                        <a href='".get_author_posts_url(get_the_author_meta('ID'))."'>".get_avatar(get_the_author_meta('ID'))."</a>
                                        <a href='".get_author_posts_url(get_the_author_meta('ID'))."'>".$comment->comment_author."</a>
                                        <p class='author'>".$comment->comment_content."</p>
                                      </li>");
                            endforeach;
                            echo "</ul></div>";
                        }
                        echo "<div class='comments-item comments-form'>".comment_form()."</div>";
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