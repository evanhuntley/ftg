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

                $date = types_render_field("event-date", array("format" => "M j, Y"));
                $location = types_render_field("location-short-name", array("raw" => true));
            ?>
                <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="event-details">
                    <span class="date"><i class="fa fa-calendar"></i><?php echo $date; ?></span>
                    <span class="location"><i class="fa fa-map-marker"></i><?php echo $location; ?></span>
                </div>
            <?php endwhile; ?>
            </div>
        </section>
    </div>
</section>

<?php get_footer(); ?>
