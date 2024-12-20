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

<!-- Social Media Section -->
<section id="social-media" class="social-media-section">
    <div class="container">
        <h2 class="section-title">Social Media</h2>
        <div class="social-links">
            <?php if (get_theme_mod('social_twitch')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_twitch')); ?>" target="_blank" class="social-link">
                    <i class="fab fa-twitch"></i>
                    <span>Twitch</span>
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('social_youtube')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_youtube')); ?>" target="_blank" class="social-link">
                    <i class="fab fa-youtube"></i>
                    <span>YouTube</span>
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('social_twitter')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" target="_blank" class="social-link">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </a>
            <?php endif; ?>

            <?php if (get_theme_mod('social_instagram')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_instagram')); ?>" target="_blank" class="social-link">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
            <?php endif; ?>

            <?php if (get_theme_mod('social_tiktok')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_tiktok')); ?>" target="_blank" class="social-link">
                    <i class="fab fa-tiktok"></i>
                    <span>TikTok</span>
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
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
