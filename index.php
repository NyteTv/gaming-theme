<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyte-Tv</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-brand">
            <span class="logo">NYTE</span>
        </div>
        <div class="nav-toggle" id="navToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#games">Games</a></li>
            <li><a href="#streams">Streams</a></li>
            <li><a href="#community">Community</a></li>
            <li><a href="#contact">Kontakt</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <div class="hero-logo">
                <img src="images/logo.png" alt="Gaming HQ Logo" class="main-logo">
            </div>
            <p>Deine zentrale Anlaufstelle für Gaming und Entertainment</p>
            <div class="cta-buttons">
                <a href="#games" class="btn btn-primary">Entdecken</a>
                <a href="#streams" class="btn btn-secondary">Live Streams</a>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- Featured Games -->
    <section id="games" class="games-section">
        <h2 class="section-title">Featured Games</h2>
        <div class="games-grid">
            <div class="game-card">
                <div class="game-image"></div>
                <div class="game-info">
                    <h3>Game Title 1</h3>
                    <p>Action RPG</p>
                    <button class="btn btn-primary">Details</button>
                </div>
            </div>
            <div class="game-card">
                <div class="game-image"></div>
                <div class="game-info">
                    <h3>Game Title 2</h3>
                    <p>Strategy</p>
                    <button class="btn btn-primary">Details</button>
                </div>
            </div>
            <div class="game-card">
                <div class="game-image"></div>
                <div class="game-info">
                    <h3>Game Title 3</h3>
                    <p>FPS</p>
                    <button class="btn btn-primary">Details</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Streams -->
    <section id="streams" class="streams-section">
        <h2 class="section-title">Live Streams</h2>
        <div class="stream-container">
            <div class="stream-card">
                <div class="stream-preview"></div>
                <div class="stream-info">
                    <h3>Stream Title</h3>
                    <p>Streamer Name</p>
                    <span class="live-badge">LIVE</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Stream Schedule -->
    <section class="stream-schedule">
        <div class="container">
            <h2 class="section-title">Streaming Schedule</h2>
            <div class="schedule-grid">
                <?php
                $weekdays = array(
                    'monday'    => 'Montag',
                    'tuesday'   => 'Dienstag',
                    'wednesday' => 'Mittwoch',
                    'thursday'  => 'Donnerstag',
                    'friday'    => 'Freitag',
                    'saturday'  => 'Samstag',
                    'sunday'    => 'Sonntag'
                );

                foreach ($weekdays as $day_key => $day_name) :
                    $is_active = get_theme_mod('stream_' . $day_key . '_active', false);
                    if ($is_active) :
                        $start_time = get_theme_mod('stream_' . $day_key . '_start', '');
                        $end_time = get_theme_mod('stream_' . $day_key . '_end', '');
                        $description = get_theme_mod('stream_' . $day_key . '_description', '');
                ?>
                <div class="schedule-day">
                    <h3><?php echo esc_html($day_name); ?></h3>
                    <div class="stream-slot">
                        <?php if ($start_time && $end_time) : ?>
                            <span class="time"><?php echo esc_html($start_time) . ' - ' . esc_html($end_time); ?></span>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <div class="stream-info">
                                <p><?php echo esc_html($description); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
    </section>

    <!-- Community -->
    <section id="community" class="community-section">
        <h2 class="section-title">Community</h2>
        <div class="social-links">
            <?php if (get_theme_mod('social_twitch')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_twitch')); ?>" class="social-link" target="_blank">
                    <i class="fab fa-twitch"></i>
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('social_youtube')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_youtube')); ?>" class="social-link" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('social_twitter')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('social_twitter')); ?>" class="social-link" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="contact-section">
        <h2 class="section-title">Kontakt</h2>
        <form class="contact-form">
            <div class="form-group">
                <input type="text" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <textarea placeholder="Nachricht" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Senden</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>NyteTv</h3>
                <p>Dein Gaming-Streamer</p>
            </div>
            <div class="footer-section">
                <h3>Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#games">Games</a></li>
                    <li><a href="#streams">Streams</a></li>
                    <li><a href="#community">Community</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 NyteTv. Alle Rechte vorbehalten.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/social-media.js"></script>
</body>
</html>
