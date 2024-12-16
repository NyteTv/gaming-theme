<?php
/**
 * Template Name: Games Page
 */

get_header(); ?>

<div class="games-page">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>

        <!-- Current Games -->
        <section class="current-games">
            <h2>Aktuelle Spiele</h2>
            <?php
            // Debug-Ausgabe vor der Query
            echo '<div style="background: #f5f5f5; padding: 10px; margin: 10px 0; color: #333;">';
            echo '<strong>Debug:</strong> Starte Games Query<br>';
            echo '</div>';
            
            $args = array(
                'post_type' => 'game',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'game_status',
                        'value' => 'current',
                        'compare' => '='
                    )
                )
            );
            $games_query = new WP_Query($args);

            // Debug-Ausgabe nach der Query
            echo '<div style="background: #f5f5f5; padding: 10px; margin: 10px 0; color: #333;">';
            echo '<strong>Query Info:</strong><br>';
            echo 'Gefundene Posts: ' . $games_query->found_posts . '<br>';
            echo 'Query SQL: ' . $games_query->request . '<br>';
            echo '</div>';
            ?>
            
            <div class="games-grid">
                <?php
                if ($games_query->have_posts()) :
                    while ($games_query->have_posts()) : $games_query->the_post();
                        $progress = get_post_meta(get_the_ID(), 'game_progress', true);
                        $platform = get_post_meta(get_the_ID(), 'game_platform', true);
                        $is_game_of_month = get_post_meta(get_the_ID(), 'game_of_month', true);
                        $permalink = get_permalink();
                        
                        // Debug-Ausgabe für jeden Post
                        echo '<div style="background: #f5f5f5; padding: 10px; margin: 10px 0; color: #333;">';
                        echo '<strong>Game Info:</strong><br>';
                        echo 'ID: ' . get_the_ID() . '<br>';
                        echo 'Titel: ' . get_the_title() . '<br>';
                        echo 'Permalink: ' . $permalink . '<br>';
                        echo 'Post Type: ' . get_post_type() . '<br>';
                        echo '</div>';
                        ?>
                        
                        <a href="<?php echo esc_url($permalink); ?>" class="game-card" data-aos="fade-up" onclick="window.location.href='<?php echo esc_url($permalink); ?>';" style="cursor: pointer;">
                            <div class="game-image">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('large');
                                } ?>
                            </div>
                            <div class="game-info">
                                <?php if ($is_game_of_month === 'yes') : ?>
                                    <span class="badge game-of-month">Game des Monats</span>
                                <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                <?php if ($platform || $progress) : ?>
                                    <p>
                                        <?php 
                                        if ($platform) echo esc_html($platform);
                                        if ($platform && $progress) echo ' | ';
                                        if ($progress) echo esc_html($progress) . '%';
                                        ?>
                                    </p>
                                <?php endif; ?>
                                <div class="progress-bar">
                                    <div class="progress" style="width: <?php echo esc_attr($progress); ?>%"></div>
                                </div>
                            </div>
                        </a>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    // Debug-Ausgabe wenn keine Posts gefunden wurden
                    echo '<div style="background: #f5f5f5; padding: 10px; margin: 10px 0; color: #333;">';
                    echo '<strong>Keine Spiele gefunden!</strong><br>';
                    echo 'Bitte überprüfen Sie, ob Spiele im WordPress-Backend erstellt wurden.';
                    echo '</div>';
                endif;
                ?>
            </div>
        </section>

        <!-- Steam Integration -->
        <section class="steam-achievements">
            <h2>Steam Achievements</h2>
            <div id="steam-achievements-container">
                <!-- Steam Achievements werden via JavaScript geladen -->
            </div>
        </section>

        <!-- Game of the Month -->
        <section class="game-of-month">
            <h2>Game of the Month</h2>
            <?php
            $args = array(
                'post_type' => 'game',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => 'game_of_month',
                        'value' => 'yes',
                        'compare' => '='
                    )
                )
            );
            $gotm_query = new WP_Query($args);

            if ($gotm_query->have_posts()) :
                while ($gotm_query->have_posts()) : $gotm_query->the_post();
                    ?>
                    <div class="gotm-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="gotm-image">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="gotm-info">
                            <h3><?php the_title(); ?></h3>
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </section>
    </div>
</div>

<?php get_footer(); ?>
