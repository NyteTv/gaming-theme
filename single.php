<?php
/**
 * The template for displaying single posts
 */

get_header(); ?>

<article class="single-post">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <header class="post-header">
                <div class="post-category">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name);
                    }
                    ?>
                </div>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                    <span class="post-author">von <?php the_author(); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <footer class="post-footer">
                <div class="post-tags">
                    <?php the_tags('Tags: ', ', '); ?>
                </div>
                
                <div class="post-navigation">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if (!empty($prev_post)) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" class="prev-post">
                            <span class="nav-label">&laquo; Vorheriger Artikel</span>
                            <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($next_post)) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>" class="next-post">
                            <span class="nav-label">Nächster Artikel &raquo;</span>
                            <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </footer>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; endif; ?>
    </div>
</article>

<?php get_footer(); ?>
