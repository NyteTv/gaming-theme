<?php
/**
 * Register Custom Post Types
 */

function gaming_website_register_post_types() {
    // Games Post Type
    $labels = array(
        'name'                  => _x('Games', 'Post Type General Name', 'gaming-website'),
        'singular_name'         => _x('Game', 'Post Type Singular Name', 'gaming-website'),
        'menu_name'            => __('Games', 'gaming-website'),
        'add_new'              => __('Neues Spiel', 'gaming-website'),
        'add_new_item'         => __('Neues Spiel hinzufügen', 'gaming-website'),
        'edit_item'            => __('Spiel bearbeiten', 'gaming-website'),
        'view_item'            => __('Spiel ansehen', 'gaming-website'),
        'all_items'            => __('Alle Spiele', 'gaming-website'),
    );

    $args = array(
        'label'               => __('Games', 'gaming-website'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-games',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'hierarchical'        => false,
        'exclude_from_search' => false,
        'show_in_rest'        => true,
        'rewrite'             => array('slug' => 'games'),
    );

    register_post_type('game', $args);
}
add_action('init', 'gaming_website_register_post_types');

// Add custom meta boxes for games
function gaming_website_add_game_meta_boxes() {
    add_meta_box(
        'game_details',
        __('Spiel Details', 'gaming-website'),
        'gaming_website_game_details_callback',
        'game',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gaming_website_add_game_meta_boxes');

// Callback function for game details meta box
function gaming_website_game_details_callback($post) {
    wp_nonce_field('gaming_website_game_details', 'gaming_website_game_details_nonce');

    $progress = get_post_meta($post->ID, 'game_progress', true);
    $platform = get_post_meta($post->ID, 'game_platform', true);
    $status = get_post_meta($post->ID, 'game_status', true);
    $game_of_month = get_post_meta($post->ID, 'game_of_month', true);
    ?>

    <div class="game-meta-box">
        <p>
            <label for="game_progress"><?php _e('Fortschritt (%)', 'gaming-website'); ?></label><br>
            <input type="number" id="game_progress" name="game_progress" value="<?php echo esc_attr($progress); ?>" min="0" max="100" style="width: 100px;">
        </p>

        <p>
            <label for="game_platform"><?php _e('Plattform', 'gaming-website'); ?></label><br>
            <select id="game_platform" name="game_platform">
                <option value=""><?php _e('Wähle eine Plattform', 'gaming-website'); ?></option>
                <option value="pc" <?php selected($platform, 'pc'); ?>>PC</option>
                <option value="ps5" <?php selected($platform, 'ps5'); ?>>PlayStation 5</option>
                <option value="xbox" <?php selected($platform, 'xbox'); ?>>Xbox Series X</option>
                <option value="switch" <?php selected($platform, 'switch'); ?>>Nintendo Switch</option>
            </select>
        </p>

        <p>
            <label for="game_status"><?php _e('Status', 'gaming-website'); ?></label><br>
            <select id="game_status" name="game_status">
                <option value=""><?php _e('Wähle einen Status', 'gaming-website'); ?></option>
                <option value="current" <?php selected($status, 'current'); ?>>Aktuell</option>
                <option value="completed" <?php selected($status, 'completed'); ?>>Abgeschlossen</option>
                <option value="planned" <?php selected($status, 'planned'); ?>>Geplant</option>
            </select>
        </p>

        <p>
            <label>
                <input type="checkbox" name="game_of_month" value="yes" <?php checked($game_of_month, 'yes'); ?>>
                <?php _e('Game des Monats', 'gaming-website'); ?>
            </label>
        </p>
    </div>
    <style>
        .game-meta-box {
            padding: 10px;
        }
        .game-meta-box p {
            margin: 15px 0;
        }
        .game-meta-box label {
            font-weight: bold;
        }
        .game-meta-box select {
            min-width: 200px;
        }
    </style>
    <?php
}

// Save game details
function gaming_website_save_game_details($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['gaming_website_game_details_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['gaming_website_game_details_nonce'], 'gaming_website_game_details')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save game progress
    if (isset($_POST['game_progress'])) {
        $progress = intval($_POST['game_progress']);
        if ($progress >= 0 && $progress <= 100) {
            update_post_meta($post_id, 'game_progress', $progress);
        }
    }

    // Save platform
    if (isset($_POST['game_platform'])) {
        update_post_meta($post_id, 'game_platform', sanitize_text_field($_POST['game_platform']));
    }

    // Save status
    if (isset($_POST['game_status'])) {
        update_post_meta($post_id, 'game_status', sanitize_text_field($_POST['game_status']));
    }

    // Save game of month
    $game_of_month = isset($_POST['game_of_month']) ? 'yes' : 'no';
    update_post_meta($post_id, 'game_of_month', $game_of_month);
}
add_action('save_post_game', 'gaming_website_save_game_details');

// Display game progress
function gaming_website_display_game_progress($post_id) {
    $progress = get_post_meta($post_id, 'game_progress', true);
    $platform = get_post_meta($post_id, 'game_platform', true);
    $status = get_post_meta($post_id, 'game_status', true);
    $game_of_month = get_post_meta($post_id, 'game_of_month', true);

    // Debug output
    error_log('Game Details Debug:');
    error_log('Post ID: ' . $post_id);
    error_log('Progress: ' . $progress);
    error_log('Platform: ' . $platform);
    error_log('Status: ' . $status);
    error_log('Game of Month: ' . $game_of_month);
    
    echo '<div class="game-details">';
    
    // Game of the Month Badge
    if ($game_of_month === 'yes') {
        echo '<div class="game-badge">';
        echo '<span class="badge game-of-month">Game des Monats</span>';
        echo '</div>';
    }
    
    // Progress Bar
    if ($progress !== '') {
        echo '<div class="game-progress">';
        echo '<span class="progress-label">Fortschritt:</span>';
        echo '<div class="progress-bar">';
        echo '<div class="progress-fill" style="width: ' . esc_attr($progress) . '%"></div>';
        echo '<span class="progress-text">' . esc_html($progress) . '%</span>';
        echo '</div></div>';
    }
    
    // Platform
    if ($platform !== '') {
        $platform_labels = array(
            'pc' => 'PC',
            'ps5' => 'PlayStation 5',
            'xbox' => 'Xbox Series X',
            'switch' => 'Nintendo Switch'
        );
        echo '<div class="game-platform">';
        echo '<span class="platform-label">Plattform:</span>';
        echo '<span class="platform-value">' . esc_html($platform_labels[$platform]) . '</span>';
        echo '</div>';
    }
    
    // Status
    if ($status !== '') {
        $status_labels = array(
            'current' => 'Aktuell',
            'completed' => 'Abgeschlossen',
            'planned' => 'Geplant'
        );
        echo '<div class="game-status">';
        echo '<span class="status-label">Status:</span>';
        echo '<span class="status-value">' . esc_html($status_labels[$status]) . '</span>';
        echo '</div>';
    }
    
    echo '</div>';
}
