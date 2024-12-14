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

// Include custom post types
require get_template_directory() . '/inc/post-types.php';

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

    // Discord URL
    $wp_customize->add_setting('discord_url');
    $wp_customize->add_control('discord_url', array(
        'label'    => __('Discord URL', 'gaming-website'),
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

    // Discord Integration
    $wp_customize->add_section('discord_section', array(
        'title'    => __('Discord Integration', 'gaming-website'),
        'priority' => 37,
    ));

    $wp_customize->add_setting('discord_widget_id');
    $wp_customize->add_control('discord_widget_id', array(
        'label'    => __('Discord Widget ID', 'gaming-website'),
        'section'  => 'discord_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'gaming_website_customize_register');

// Theme Scripts und Styles
function gaming_website_scripts() {
    wp_enqueue_style('gaming-website-style', get_stylesheet_uri());
    wp_enqueue_script('gaming-website-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('gaming-website-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true);
    
    // Dark Mode Script
    wp_enqueue_script('dark-mode', get_template_directory_uri() . '/js/dark-mode.js', array('jquery'), '1.0.0', true);
    
    // Twitch API
    wp_enqueue_script('twitch-embed', 'https://embed.twitch.tv/embed/v1.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'gaming_website_scripts');
