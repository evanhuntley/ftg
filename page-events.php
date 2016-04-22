<?php
    /* Template Name: Events Page */
?>
<?php get_header(); ?>

<section class="section-header home-hero">
    <div class="container">
        <h1>Events</h1>
    </div>
</section>

<section class="featured-content">
    <div class="container">
        <section class="featured-events">
            <?php
                $args = array(
                    'post_type' => 'events'
                );
                $events = new WP_Query( $args);
            ?>

            <div class="events-list">
            <?php
                while ( $events->have_posts() ) : $events->the_post();
            ?>
                <?php the_title(); ?>
            <?php endwhile; ?>
            </div>
        </section>
    </div>
</section>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>
