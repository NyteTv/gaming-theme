<?php 
get_header(); 
?>

<div class="container">
    <div class="blog-section">
        <h1>Blog & News</h1>
        <div class="blog-grid">
            <?php 
            // Debug-Ausgabe
            echo '<!-- Shortcode exists check: ' . (shortcode_exists('grid_composer') ? 'true' : 'false') . ' -->';
            
            if(shortcode_exists('grid_composer')) {
                $grid_output = do_shortcode('[grid_composer id="193"]');
                if(empty(trim($grid_output))) {
                    echo '<p>Das Grid wurde gefunden, aber es gibt keine Posts anzuzeigen. Bitte überprüfen Sie die Grid-Einstellungen und ob Posts vorhanden sind.</p>';
                } else {
                    echo $grid_output;
                }
            } else {
                echo '<p>Das Grid Composer Plugin ist nicht richtig installiert oder aktiviert.</p>';
            }
            
            // Debug-Ausgabe für Posts
            $posts = get_posts(array('post_type' => 'post', 'posts_per_page' => -1));
            echo '<!-- Anzahl verfügbarer Posts: ' . count($posts) . ' -->';
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>