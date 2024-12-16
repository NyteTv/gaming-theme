<?php
/**
 * Template Name: XML Sitemap
 */

// Setzt den Content-Type auf XML
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc><?php echo esc_url(home_url('/')); ?></loc>
        <lastmod><?php echo date('Y-m-d\TH:i:sP', strtotime(get_lastpostmodified('GMT'))); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Games -->
    <?php
    $games = new WP_Query(array(
        'post_type' => 'game',
        'posts_per_page' => -1,
    ));

    if ($games->have_posts()) :
        while ($games->have_posts()) : $games->the_post();
    ?>
        <url>
            <loc><?php echo esc_url(get_permalink()); ?></loc>
            <lastmod><?php echo date('Y-m-d\TH:i:sP', strtotime(get_the_modified_date('Y-m-d H:i:s'))); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <!-- Blog Posts -->
    <?php
    $posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    ));

    if ($posts->have_posts()) :
        while ($posts->have_posts()) : $posts->the_post();
    ?>
        <url>
            <loc><?php echo esc_url(get_permalink()); ?></loc>
            <lastmod><?php echo date('Y-m-d\TH:i:sP', strtotime(get_the_modified_date('Y-m-d H:i:s'))); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <!-- Pages -->
    <?php
    $pages = new WP_Query(array(
        'post_type' => 'page',
        'posts_per_page' => -1,
    ));

    if ($pages->have_posts()) :
        while ($pages->have_posts()) : $pages->the_post();
    ?>
        <url>
            <loc><?php echo esc_url(get_permalink()); ?></loc>
            <lastmod><?php echo date('Y-m-d\TH:i:sP', strtotime(get_the_modified_date('Y-m-d H:i:s'))); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</urlset>
