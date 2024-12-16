<?php
/**
 * The template for displaying game archives
 */

get_header(); ?>

<div class="games-page">
    <div class="container">
        <h1 class="page-title">Games</h1>

        <div class="games-grid">
            <?php
            $args = array(
                'post_type' => 'game',
                'posts_per_page' => -1,
            );
            $games_query = new WP_Query($args);

            // Debug-Ausgabe
            echo '<!-- Debug: ';
            echo 'Found Posts: ' . $games_query->found_posts . "\n";
            echo 'Query vars: ';
            print_r($games_query->query_vars);
            echo ' -->';

            if ($games_query->have_posts()) :
                while ($games_query->have_posts()) : $games_query->the_post();
                    $progress = get_post_meta(get_the_ID(), 'game_progress', true);
                    $platform = get_post_meta(get_the_ID(), 'game_platform', true);
                    $is_game_of_month = get_post_meta(get_the_ID(), 'game_of_month', true);
                    $status = get_post_meta(get_the_ID(), 'game_status', true);
                    $youtube_url = get_post_meta(get_the_ID(), 'game_youtube_url', true);
                    ?>
                    <div class="game-card <?php echo esc_attr($status); ?>" data-aos="fade-up">
                        <div class="game-image">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('large');
                            } ?>
                            <?php if ($is_game_of_month === 'yes') : ?>
                                <span class="badge game-of-month">Game des Monats</span>
                            <?php endif; ?>
                            <?php if ($status) : ?>
                                <span class="badge game-status <?php echo esc_attr($status); ?>">
                                    <?php 
                                    switch($status) {
                                        case 'current':
                                            echo 'Aktuell';
                                            break;
                                        case 'completed':
                                            echo 'Abgeschlossen';
                                            break;
                                        case 'planned':
                                            echo 'Geplant';
                                            break;
                                        default:
                                            echo esc_html($status);
                                    }
                                    ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($youtube_url) : ?>
                                <a href="<?php echo esc_url($youtube_url); ?>" class="youtube-btn" target="_blank" rel="noopener">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="game-info">
                            <h3><?php the_title(); ?></h3>
                            
                            <div class="game-details">
                                <?php if ($platform) : ?>
                                    <div class="platform">
                                        <span class="label">Plattform:</span>
                                        <span class="value"><?php echo esc_html($platform); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($progress && $status === 'current') : ?>
                                    <div class="progress-container">
                                        <span class="label">Fortschritt:</span>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: <?php echo esc_attr($progress); ?>%"></div>
                                            <div class="progress-text"><?php echo esc_html($progress); ?>%</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="game-description">
                                <?php the_content(); ?>
                            </div>

                            <?php
                            // Hole alle benutzerdefinierten Felder
                            $custom_fields = get_post_custom();
                            if (!empty($custom_fields)) : ?>
                                <div class="additional-info">
                                    <ul>
                                        <?php foreach ($custom_fields as $key => $values) :
                                            // Überspringe interne WordPress-Felder, bereits angezeigte Felder und Ultpgrid-Felder
                                            if (substr($key, 0, 1) === '_' || 
                                                in_array($key, ['game_progress', 'game_platform', 'game_of_month', 'game_status', 'game_youtube_url']) ||
                                                strpos($key, 'ultpgrid') !== false) continue;
                                            ?>
                                            <li>
                                                <strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $key))); ?>:</strong>
                                                <?php echo esc_html($values[0]); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p class="no-games">Aktuell sind keine Spiele vorhanden.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
