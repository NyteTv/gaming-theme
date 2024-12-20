<?php 
// Debug information
if (!defined('ABSPATH')) {
    echo "WordPress-Umgebung nicht geladen!";
    exit;
}

// Remove stream schedule from single game pages
remove_action('wp_footer', 'display_stream_schedule');
get_header(); 
?>

<!-- Debug Info -->
<div style="display: none;">
    <?php 
    echo "Template: single-game.php<br>";
    echo "Post ID: " . get_the_ID() . "<br>";
    echo "Post Type: " . get_post_type() . "<br>";
    ?>
</div>

<main class="site-main">
    <article class="single-game">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="game-hero">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full', ['class' => 'hero-image']); ?>
                <?php endif; ?>
                
                <div class="hero-content">
                    <h1 class="game-title"><?php the_title(); ?></h1>
                    
                    <?php if (function_exists('gaming_website_display_game_progress')) {
                        gaming_website_display_game_progress(get_the_ID());
                    } ?>
                </div>
            </div>

            <div class="content-wrapper">
                <div class="container">
                    <div class="game-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </article>
</main>

<?php get_footer(); ?>
