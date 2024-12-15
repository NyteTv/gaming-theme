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
