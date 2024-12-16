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

                if ($games_query->have_posts()) :
                    while ($games_query->have_posts()) : $games_query->the_post();
                        $progress = get_post_meta(get_the_ID(), 'game_progress', true);
                        $platform = get_post_meta(get_the_ID(), 'game_platform', true);
                        $is_game_of_month = get_post_meta(get_the_ID(), 'game_of_month', true);
                        ?>
                        <a href="<?php the_permalink(); ?>" class="game-card" data-aos="fade-up">
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
