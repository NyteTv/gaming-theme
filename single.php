<?php get_header(); ?>

<article class="single-post">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <div class="post-hero">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('full', ['class' => 'hero-image']); ?>
            <?php endif; ?>
            
            <div class="hero-content">
                <div class="post-meta">
                    <div class="post-category">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                        ?>
                    </div>
                    <div class="post-date">
                        <?php echo get_the_date(); ?>
                    </div>
                </div>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-info">
                    <div class="author-info">
                        <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                        <span><?php the_author(); ?></span>
                    </div>
                    <div class="reading-time">
                        <?php
                        $content = get_the_content();
                        $word_count = str_word_count(strip_tags($content));
                        $reading_time = ceil($word_count / 200); // 200 words per minute
                        echo $reading_time . ' min read';
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="container">
                <div class="post-content">
                    <?php the_content(); ?>
                    
                    <div class="post-tags">
                        <?php the_tags('<span class="tag-label">Tags:</span> ', ', '); ?>
                    </div>
                </div>

                <div class="post-footer">
                    <div class="share-buttons">
                        <span>Share this article:</span>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-button twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-button facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>

                <nav class="post-navigation">
                    <div class="prev-post">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)) :
                        ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                <span class="nav-label">Previous Post</span>
                                <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="next-post">
                        <?php
                        $next_post = get_next_post();
                        if (!empty($next_post)) :
                        ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>">
                                <span class="nav-label">Next Post</span>
                                <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>
    <?php endwhile; endif; ?>
</article>

<?php get_footer(); ?>
