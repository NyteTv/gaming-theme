<?php
/**
 * Custom Grid Card Template
 */
?>
<div class="grid-item">
    <article class="post-card">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-card-image">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large', array('class' => 'card-img')); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <div class="post-card-content">
            <header class="post-card-header">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) :
                ?>
                    <div class="post-card-categories">
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <h2 class="post-card-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
            </header>
            
            <div class="post-card-excerpt">
                <?php echo get_the_excerpt(); ?>
            </div>
            
            <footer class="post-card-meta">
                <div class="post-card-author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 30); ?>
                    <span><?php the_author(); ?></span>
                </div>
                <time class="post-card-date" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </footer>
            
            <a href="<?php the_permalink(); ?>" class="post-card-link">Weiterlesen</a>
        </div>
    </article>
</div>
