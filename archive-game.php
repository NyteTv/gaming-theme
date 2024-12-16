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
                                                in_array($key, ['game_progress', 'game_platform', 'game_of_month', 'game_status']) ||
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
