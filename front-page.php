<?php get_header(); ?>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="hero-content">
        <div class="hero-logo">
            <?php 
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (has_custom_logo()) {
                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="main-logo">';
            }
            ?>
        </div>
        <p><?php echo get_bloginfo('description'); ?></p>
        <div class="cta-buttons">
            <a href="#about" class="btn btn-primary">Über Mich</a>
            <a href="<?php echo esc_url(home_url('/streams')); ?>" class="btn btn-secondary">Live Streams</a>
        </div>
    </div>
    <div class="hero-overlay"></div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <h2 class="section-title">Über Mich</h2>
        <div class="about-content">
            <?php if ($about_image = get_theme_mod('about_image')) : ?>
                <div class="about-image">
                    <img src="<?php echo esc_url($about_image); ?>" alt="Über Mich">
                </div>
            <?php endif; ?>
            <div class="about-text">
                <?php 
                $about_text = get_theme_mod('about_text');
                $about_text = wpautop($about_text);
                echo wp_kses_post($about_text);
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Community Section -->
<section id="community" class="community-section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html__('Social Media', 'gaming-website'); ?></h2>
        <div class="social-links">
            <?php if (get_theme_mod('twitch_url')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('twitch_url')); ?>" target="_blank" class="social-link twitch">
                    <i class="fab fa-twitch"></i>
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('youtube_url')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('youtube_url')); ?>" target="_blank" class="social-link youtube">
                    <i class="fab fa-youtube"></i>
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('twitter_url')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>" target="_blank" class="social-link twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <h2 class="section-title">Kontakt</h2>
        <div class="contact-content">
            <div class="contact-info">
                <p>Du hast Fragen, Anregungen oder möchtest einfach Hallo sagen? Schreib mir gerne eine Nachricht!</p>
                <div class="social-links">
                    <?php if ($twitch_url = get_theme_mod('twitch_url')) : ?>
                        <a href="<?php echo esc_url($twitch_url); ?>" target="_blank" class="social-link twitch">
                            <i class="fab fa-twitch"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($youtube_url = get_theme_mod('youtube_url')) : ?>
                        <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" class="social-link youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="contact-form">
                <?php echo do_shortcode('[contact-form-7 id="a7cff6e" title="Kontaktformular 1"]'); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
