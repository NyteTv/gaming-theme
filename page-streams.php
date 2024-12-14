<?php
/**
 * Template Name: Streams Page
 */

get_header(); ?>

<div class="stream-page">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>

        <!-- Stream Embed -->
        <div class="stream-embed">
            <div id="twitch-embed"></div>
        </div>

        <!-- Stream Schedule -->
        <div class="stream-schedule">
            <h2>Stream Zeiten</h2>
            <div class="schedule-grid">
                <?php
                $schedule = array(
                    'Montag' => '20:00 - 23:00',
                    'Mittwoch' => '20:00 - 23:00',
                    'Freitag' => '21:00 - 00:00',
                    'Sonntag' => '19:00 - 22:00'
                );

                foreach ($schedule as $day => $time) : ?>
                    <div class="schedule-item">
                        <span class="day"><?php echo $day; ?></span>
                        <span class="time"><?php echo $time; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Latest Clips -->
        <div class="latest-clips">
            <h2>Neueste Clips</h2>
            <div id="twitch-clips" class="clips-grid"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const twitchUsername = '<?php echo esc_js(get_theme_mod('twitch_username')); ?>';
    
    // Twitch Embed
    new Twitch.Embed("twitch-embed", {
        width: '100%',
        height: 480,
        channel: twitchUsername,
        layout: "video"
    });

    // Fetch Clips (Beispiel - erfordert Twitch API Implementation)
    // Diese Funktion muss noch mit der tatsächlichen Twitch API verbunden werden
    async function fetchTwitchClips() {
        // TODO: Implement Twitch API call
    }

    fetchTwitchClips();
});
</script>

<?php get_footer(); ?>
