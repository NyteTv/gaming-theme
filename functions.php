<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Setup
function gaming_website_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'gaming-website'),
        'footer'  => esc_html__('Footer Menu', 'gaming-website'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'gaming_website_setup');

// Remove category base
function remove_category_base() {
    add_action('init', function() {
        // Remove category base
        global $wp_rewrite;
        $wp_rewrite->categories_base = '';
        $wp_rewrite->flush_rules();
    });
}
add_action('after_setup_theme', 'remove_category_base');

// Redirect old category URLs to new clean URLs
function redirect_old_category_urls() {
    if (is_category() && strpos($_SERVER['REQUEST_URI'], '/category/') !== false) {
        $category = get_category(get_query_var('cat'));
        wp_redirect(get_category_link($category->cat_ID), 301);
        exit();
    }
}
add_action('template_redirect', 'redirect_old_category_urls');

// Custom rewrite rules for games
function custom_games_rewrite_rules() {
    add_rewrite_rule(
        '^games/?$',
        'index.php?pagename=games',
        'top'
    );
    flush_rewrite_rules();
}
add_action('init', 'custom_games_rewrite_rules');

// Include custom post types
require get_template_directory() . '/inc/post-types.php';

// Register Page Templates
function gaming_website_add_page_templates($templates) {
    $templates['page-templates/template-blog-grid.php'] = 'Blog Grid Layout';
    return $templates;
}
add_filter('theme_page_templates', 'gaming_website_add_page_templates');

// Customizer Einstellungen
function gaming_website_customize_register($wp_customize) {
    // About Section
    $wp_customize->add_section('about_section', array(
        'title'    => __('Über Mich Section', 'gaming-website'),
        'priority' => 30,
    ));

    // About Image
    $wp_customize->add_setting('about_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_image', array(
        'label'    => __('Profilbild', 'gaming-website'),
        'section'  => 'about_section',
        'settings' => 'about_image',
    )));

    // About Text
    $wp_customize->add_setting('about_text', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_text', array(
        'label'    => __('Über Mich Text', 'gaming-website'),
        'section'  => 'about_section',
        'type'     => 'textarea',
    ));

    // SEO Settings
    $wp_customize->add_section('seo_settings', array(
        'title'    => __('SEO Einstellungen', 'gaming-website'),
        'priority' => 20,
    ));

    // Social Media Settings
    $wp_customize->add_section('social_media_settings', array(
        'title'    => __('Social Media Links', 'gaming-website'),
        'priority' => 25,
    ));

    // Twitch URL
    $wp_customize->add_setting('social_twitch', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('social_twitch', array(
        'label'    => __('Twitch URL', 'gaming-website'),
        'section'  => 'social_media_settings',
        'type'     => 'url',
    ));

    // YouTube URL
    $wp_customize->add_setting('social_youtube', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('social_youtube', array(
        'label'    => __('YouTube URL', 'gaming-website'),
        'section'  => 'social_media_settings',
        'type'     => 'url',
    ));

    // Twitter URL
    $wp_customize->add_setting('social_twitter', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('social_twitter', array(
        'label'    => __('Twitter URL', 'gaming-website'),
        'section'  => 'social_media_settings',
        'type'     => 'url',
    ));

    // Instagram URL
    $wp_customize->add_setting('social_instagram', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('social_instagram', array(
        'label'    => __('Instagram URL', 'gaming-website'),
        'section'  => 'social_media_settings',
        'type'     => 'url',
    ));

    // TikTok URL
    $wp_customize->add_setting('social_tiktok', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('social_tiktok', array(
        'label'    => __('TikTok URL', 'gaming-website'),
        'section'  => 'social_media_settings',
        'type'     => 'url',
    ));

    // Stream Schedule Settings
    $wp_customize->add_section('stream_schedule_settings', array(
        'title'    => __('Stream Zeitplan', 'gaming-website'),
        'priority' => 26,
    ));

    // Wochentage Array für die Schleife
    $weekdays = array(
        'monday'    => 'Montag',
        'tuesday'   => 'Dienstag',
        'wednesday' => 'Mittwoch',
        'thursday'  => 'Donnerstag',
        'friday'    => 'Freitag',
        'saturday'  => 'Samstag',
        'sunday'    => 'Sonntag'
    );

    foreach ($weekdays as $day_key => $day_name) {
        // Stream aktiv für diesen Tag
        $wp_customize->add_setting('stream_' . $day_key . '_active', array(
            'default'   => false,
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('stream_' . $day_key . '_active', array(
            'label'    => sprintf(__('%s - Stream aktiv', 'gaming-website'), $day_name),
            'section'  => 'stream_schedule_settings',
            'type'     => 'checkbox',
        ));

        // Stream Startzeit
        $wp_customize->add_setting('stream_' . $day_key . '_start', array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('stream_' . $day_key . '_start', array(
            'label'    => sprintf(__('%s - Startzeit', 'gaming-website'), $day_name),
            'section'  => 'stream_schedule_settings',
            'type'     => 'time',
        ));

        // Stream Endzeit
        $wp_customize->add_setting('stream_' . $day_key . '_end', array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('stream_' . $day_key . '_end', array(
            'label'    => sprintf(__('%s - Endzeit', 'gaming-website'), $day_name),
            'section'  => 'stream_schedule_settings',
            'type'     => 'time',
        ));

        // Stream Titel/Beschreibung
        $wp_customize->add_setting('stream_' . $day_key . '_description', array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('stream_' . $day_key . '_description', array(
            'label'    => sprintf(__('%s - Stream Beschreibung', 'gaming-website'), $day_name),
            'section'  => 'stream_schedule_settings',
            'type'     => 'text',
        ));
    }

    // Meta Description
    $wp_customize->add_setting('seo_description', array(
        'default'   => 'Gaming und Streaming Community - Let\'s Plays, Reviews und mehr',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('seo_description', array(
        'label'       => __('Meta Beschreibung', 'gaming-website'),
        'description' => __('Die Beschreibung deiner Website für Suchmaschinen (max. 160 Zeichen)', 'gaming-website'),
        'section'     => 'seo_settings',
        'type'        => 'textarea',
    ));

    // Meta Keywords
    $wp_customize->add_setting('seo_keywords', array(
        'default'   => 'Gaming, Streaming, Let\'s Play, Twitch, Gaming Community',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('seo_keywords', array(
        'label'       => __('Meta Keywords', 'gaming-website'),
        'description' => __('Kommagetrennte Liste von Schlüsselwörtern', 'gaming-website'),
        'section'     => 'seo_settings',
        'type'        => 'text',
    ));

    // OG Image
    $wp_customize->add_setting('seo_og_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seo_og_image', array(
        'label'       => __('Social Media Vorschaubild', 'gaming-website'),
        'description' => __('Dieses Bild wird angezeigt, wenn deine Website in sozialen Medien geteilt wird', 'gaming-website'),
        'section'     => 'seo_settings',
    )));

    // Social Media & Contact Section
    $wp_customize->add_section('contact_section', array(
        'title'    => __('Kontakt & Social Media', 'gaming-website'),
        'priority' => 35,
    ));

    // Twitch URL
    $wp_customize->add_setting('twitch_url');
    $wp_customize->add_control('twitch_url', array(
        'label'    => __('Twitch URL', 'gaming-website'),
        'section'  => 'contact_section',
        'type'     => 'url',
    ));

    // YouTube URL
    $wp_customize->add_setting('youtube_url');
    $wp_customize->add_control('youtube_url', array(
        'label'    => __('YouTube URL', 'gaming-website'),
        'section'  => 'contact_section',
        'type'     => 'url',
    ));

    // Discord Widget URL
    $wp_customize->add_setting('discord_widget_url');
    $wp_customize->add_control('discord_widget_url', array(
        'label'    => __('Discord Widget URL', 'gaming-website'),
        'section'  => 'contact_section',
        'type'     => 'url',
    ));

    // Contact Form 7 ID
    $wp_customize->add_setting('contact_form_id', array(
        'default' => 'a7cff6e',
    ));
    $wp_customize->add_control('contact_form_id', array(
        'label'    => __('Contact Form 7 ID', 'gaming-website'),
        'section'  => 'contact_section',
        'type'     => 'text',
        'description' => __('Gib hier die ID deines Contact Form 7 Formulars ein (z.B. a7cff6e)', 'gaming-website'),
    ));

    // Twitch Integration
    $wp_customize->add_section('twitch_section', array(
        'title'    => __('Twitch Integration', 'gaming-website'),
        'priority' => 36,
    ));

    $wp_customize->add_setting('twitch_username');
    $wp_customize->add_control('twitch_username', array(
        'label'    => __('Twitch Benutzername', 'gaming-website'),
        'section'  => 'twitch_section',
        'type'     => 'text',
    ));

    // Stream Schedule Settings
    $wp_customize->add_section('stream_schedule_section', array(
        'title'    => __('Stream Zeiten', 'gaming-website'),
        'priority' => 30,
    ));

    // Monday
    $wp_customize->add_setting('stream_monday', array(
        'default'   => '20:00 - 23:00',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('stream_monday', array(
        'label'    => __('Montag', 'gaming-website'),
        'section'  => 'stream_schedule_section',
        'type'     => 'text',
    ));

    // Wednesday
    $wp_customize->add_setting('stream_wednesday', array(
        'default'   => '20:00 - 23:00',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('stream_wednesday', array(
        'label'    => __('Mittwoch', 'gaming-website'),
        'section'  => 'stream_schedule_section',
        'type'     => 'text',
    ));

    // Friday
    $wp_customize->add_setting('stream_friday', array(
        'default'   => '21:00 - 00:00',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('stream_friday', array(
        'label'    => __('Freitag', 'gaming-website'),
        'section'  => 'stream_schedule_section',
        'type'     => 'text',
    ));

    // Sunday
    $wp_customize->add_setting('stream_sunday', array(
        'default'   => '19:00 - 22:00',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('stream_sunday', array(
        'label'    => __('Sonntag', 'gaming-website'),
        'section'  => 'stream_schedule_section',
        'type'     => 'text',
    ));

    // Stream Schedule Active Days
    $wp_customize->add_setting('stream_active_days', array(
        'default'   => array('monday', 'wednesday', 'friday', 'sunday'),
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'stream_active_days',
        array(
            'label'    => __('Aktive Stream-Tage', 'gaming-website'),
            'section'  => 'stream_schedule_section',
            'type'     => 'select',
            'choices'  => array(
                'monday'    => __('Montag', 'gaming-website'),
                'wednesday' => __('Mittwoch', 'gaming-website'),
                'friday'    => __('Freitag', 'gaming-website'),
                'sunday'    => __('Sonntag', 'gaming-website'),
            ),
            'multiple' => true,
        )
    ));
}
add_action('customize_register', 'gaming_website_customize_register');

// Register Game Custom Fields
function register_game_meta_boxes() {
    add_meta_box(
        'game_details', // Unique ID
        'Game Details', // Box title
        'game_details_html', // Content callback, must be of type callable
        'game' // Post type
    );
}
add_action('add_meta_boxes', 'register_game_meta_boxes');

// Game Details Meta Box HTML
function game_details_html($post) {
    $progress = get_post_meta($post->ID, 'game_progress', true);
    $platform = get_post_meta($post->ID, 'game_platform', true);
    $status = get_post_meta($post->ID, 'game_status', true);
    $is_game_of_month = get_post_meta($post->ID, 'game_of_month', true);
    $youtube_url = get_post_meta($post->ID, 'game_youtube_url', true);
    
    // Add nonce for security
    wp_nonce_field('game_details_nonce', 'game_details_nonce');
    ?>
    <div class="game-fields">
        <p>
            <label for="game_platform">Plattform:</label>
            <input type="text" id="game_platform" name="game_platform" value="<?php echo esc_attr($platform); ?>">
        </p>
        
        <p>
            <label for="game_progress">Fortschritt (%):</label>
            <input type="number" id="game_progress" name="game_progress" value="<?php echo esc_attr($progress); ?>" min="0" max="100">
        </p>
        
        <p>
            <label for="game_status">Status:</label>
            <select id="game_status" name="game_status">
                <option value="planned" <?php selected($status, 'planned'); ?>>Geplant</option>
                <option value="current" <?php selected($status, 'current'); ?>>Aktuell</option>
                <option value="completed" <?php selected($status, 'completed'); ?>>Abgeschlossen</option>
            </select>
        </p>
        
        <p>
            <label for="game_of_month">Game des Monats:</label>
            <select id="game_of_month" name="game_of_month">
                <option value="no" <?php selected($is_game_of_month, 'no'); ?>>Nein</option>
                <option value="yes" <?php selected($is_game_of_month, 'yes'); ?>>Ja</option>
            </select>
        </p>

        <p>
            <label for="game_youtube_url">YouTube Video URL:</label>
            <input type="url" id="game_youtube_url" name="game_youtube_url" value="<?php echo esc_url($youtube_url); ?>" style="width: 100%;">
            <small>Füge hier die vollständige YouTube-URL ein (z.B. https://www.youtube.com/watch?v=xxxx)</small>
        </p>
    </div>

    <style>
        .game-fields label {
            display: inline-block;
            min-width: 150px;
            font-weight: bold;
        }
        .game-fields input[type="text"],
        .game-fields input[type="number"],
        .game-fields select {
            min-width: 200px;
        }
        .game-fields p {
            margin: 1em 0;
        }
    </style>
    <?php
}

// Save Game Details
function save_game_details($post_id) {
    // Check if nonce is set
    if (!isset($_POST['game_details_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['game_details_nonce'], 'game_details_nonce')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save fields
    if (isset($_POST['game_platform'])) {
        update_post_meta($post_id, 'game_platform', sanitize_text_field($_POST['game_platform']));
    }
    
    if (isset($_POST['game_progress'])) {
        update_post_meta($post_id, 'game_progress', sanitize_text_field($_POST['game_progress']));
    }
    
    if (isset($_POST['game_status'])) {
        update_post_meta($post_id, 'game_status', sanitize_text_field($_POST['game_status']));
    }
    
    if (isset($_POST['game_of_month'])) {
        update_post_meta($post_id, 'game_of_month', sanitize_text_field($_POST['game_of_month']));
    }

    if (isset($_POST['game_youtube_url'])) {
        update_post_meta($post_id, 'game_youtube_url', esc_url_raw($_POST['game_youtube_url']));
    }
}
add_action('save_post_game', 'save_game_details');

// Theme Scripts und Styles
function gaming_website_scripts() {
    // Base Stylesheet (Reset und Variablen)
    wp_enqueue_style('gaming-website-base', get_stylesheet_uri(), array(), '1.0');
    
    // Main Stylesheet (Komponenten und spezifische Styles)
    wp_enqueue_style('gaming-website-main', get_template_directory_uri() . '/css/style.css', array('gaming-website-base'), '1.0');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    
    // Theme JavaScript
    wp_enqueue_script('gaming-website-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'gaming_website_scripts');
