<?php
/**
 * The template for displaying game archives
 */

get_header(); ?>

<div class="games-page">
    <div class="container">
        <h1 class="page-title">Games</h1>

        <!-- Current Games -->
        <section class="current-games">
            <h2>Aktuelle Spiele</h2>
            <div class="games-grid">
                <?php
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
                        ?>
                        <div class="game-card expanded" data-aos="fade-up">
                            <div class="game-image">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('large');
                                } ?>
                                <?php if ($is_game_of_month === 'yes') : ?>
                                    <span class="badge game-of-month">Game des Monats</span>
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
                                    
                                    <?php if ($progress) : ?>
                                        <div class="progress-container">
                                            <span class="label">Fortschritt:</span>
                                            <div class="progress-bar">
                                                <div class="progress" style="width: <?php echo esc_attr($progress); ?>%"></div>
                                            </div>
                                            <span class="progress-text"><?php echo esc_html($progress); ?>%</span>
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
                                        <h4>Weitere Informationen</h4>
                                        <ul>
                                            <?php foreach ($custom_fields as $key => $values) :
                                                // Überspringe interne WordPress-Felder und bereits angezeigte Felder
                                                if (substr($key, 0, 1) === '_' || in_array($key, ['game_progress', 'game_platform', 'game_of_month', 'game_status'])) continue;
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
        </section>

        <!-- Completed Games -->
        <section class="completed-games">
            <h2>Abgeschlossene Spiele</h2>
            <div class="games-grid">
                <?php
                $completed_args = array(
                    'post_type' => 'game',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'game_status',
                            'value' => 'completed',
                            'compare' => '='
                        )
                    )
                );
                $completed_query = new WP_Query($completed_args);

                // Debug-Ausgabe
                echo '<!-- Debug: ';
                echo 'Found Posts: ' . $completed_query->found_posts . "\n";
                echo 'Query vars: ';
                print_r($completed_query->query_vars);
                echo ' -->';

                if ($completed_query->have_posts()) :
                    while ($completed_query->have_posts()) : $completed_query->the_post();
                        $platform = get_post_meta(get_the_ID(), 'game_platform', true);
                        ?>
                        <div class="game-card" data-aos="fade-up">
                            <div class="game-image">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('large');
                                } ?>
                            </div>
                            <div class="game-info">
                                <h3><?php the_title(); ?></h3>
                                <?php if ($platform) : ?>
                                    <div class="platform">
                                        <span class="label">Plattform:</span>
                                        <span class="value"><?php echo esc_html($platform); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="game-description">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p class="no-games">Keine abgeschlossenen Spiele vorhanden.</p>';
                endif;
                ?>
            </div>
        </section>
    </div>
</div>

<?php get_footer(); ?>
