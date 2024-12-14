<?php
/**
 * Template Name: Blog Page
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="grid-container">
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 9,
            'paged' => $paged
        );
        
        $blog_query = new WP_Query($args);
        
        if ($blog_query->have_posts()) :
        ?>
            <div class="grid-items">
                <?php
                while ($blog_query->have_posts()) :
                    $blog_query->the_post();
                    get_template_part('template-parts/grid/card');
                endwhile;
                ?>
            </div>

            <?php
            echo '<div class="pagination">';
            echo paginate_links(array(
                'total' => $blog_query->max_num_pages,
                'current' => $paged,
                'prev_text' => '&laquo; Zurück',
                'next_text' => 'Weiter &raquo;'
            ));
            echo '</div>';
            
            wp_reset_postdata();
        else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div>
</main>

<?php
get_footer();