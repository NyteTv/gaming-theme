<?php
/**
 * The main template file
 */

get_header();
?>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="hero-content">
        <div class="hero-logo">
            <?php 
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (has_custom_logo()) {
                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="main-logo">';
            }
            ?>
        </div>
        <p><?php echo get_bloginfo('description'); ?></p>
        <div class="cta-buttons">
            <a href="#games" class="btn btn-primary">Entdecken</a>
            <a href="#streams" class="btn btn-secondary">Live Streams</a>
        </div>
    </div>
    <div class="hero-overlay"></div>
</section>

<!-- Featured Games -->
<section id="games" class="games-section">
    <h2 class="section-title">Featured Games</h2>
    <div class="games-grid">
        <?php
        $args = array(
            'post_type' => 'game',
            'posts_per_page' => 6
        );
        $game_query = new WP_Query($args);
        
        if ($game_query->have_posts()) :
            while ($game_query->have_posts()) : $game_query->the_post();
        ?>
            <div class="game-card">
                <div class="game-image">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail();
                    } ?>
                </div>
                <div class="game-info">
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<?php
get_footer();
