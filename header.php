<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Navigation -->
<nav class="navbar">
    <div class="nav-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">NYTE</a>
    </div>
    
    <?php
    // Hauptnavigation
    $menu_args = array(
        'theme_location' => 'primary',
        'menu_class'     => 'nav-links',
        'container'      => false,
        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
        'fallback_cb'    => false,
        'link_before'    => '<span>',
        'link_after'     => '</span>'
    );
    wp_nav_menu($menu_args);
    ?>

    <div class="nav-toggle" id="navToggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>
