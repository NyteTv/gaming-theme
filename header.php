<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo esc_attr(get_theme_mod('seo_description', 'Gaming und Streaming Community - Let\'s Plays, Reviews und mehr')); ?>">
    <meta name="keywords" content="<?php echo esc_attr(get_theme_mod('seo_keywords', 'Gaming, Streaming, Let\'s Play, Twitch, Gaming Community')); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta property="og:description" content="<?php echo esc_attr(get_theme_mod('seo_description')); ?>">
    <meta property="og:image" content="<?php echo esc_url(get_theme_mod('seo_og_image')); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <?php wp_head(); ?>
    
    <!-- Strukturierte Daten für Gaming Website -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo esc_js(get_bloginfo('name')); ?>",
        "description": "<?php echo esc_js(get_theme_mod('seo_description')); ?>",
        "url": "<?php echo esc_url(home_url()); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo esc_url(home_url('/')); ?>?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navigation -->
<nav class="navbar">
    <div class="nav-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">NYTE</a>
    </div>
    
    <button class="menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'menu desktop-menu',
        'container'      => false,
    ));
    ?>
</nav>

<div class="mobile-menu">
    <button class="close-menu">
        <i class="fas fa-times"></i>
    </button>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'menu',
        'container'      => false,
    ));
    ?>
</div>
