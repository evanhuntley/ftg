<?php
    /* Template Name: Events Page */
?>
<?php get_header(); ?>

<section class="section-header home-hero">
    <div class="container">
        <h1>Events</h1>
    </div>
</section>

<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <div class="container">
        <?php if(function_exists('bcn_display'))
        {
            bcn_display();
        }?>
    </div>
</div>

<section role="main" class="primary-content">
    <div class="container">
            <?php
                // Only show the appopriate events based on permissions.
                if ( !rcp_is_active() ) {
                    $premium_ids = rcp_get_paid_posts();
                } else {
                    $premium_ids = array();
                }

                $args = array(
                    'post_type' => 'events',
                    'posts_per_page' => 8,
                    'post__not_in' => $premium_ids,
                    'orderby' => 'meta_value',
                    'meta_key'  => 'wpcf-event-date',
                    'order' => 'DESC'
                );
                $events = new WP_Query( $args);
            ?>

            <ul class="events-list">
            <?php
                while ( $events->have_posts() ) : $events->the_post();

                $date = types_render_field("event-date", array("format" => "M j, Y"));
                $location = types_render_field("location-short-name", array("raw" => true));
                $description = types_render_field("event-short-description", array("raw" => true));
            ?>
                <li>
                    <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo the_post_thumbnail_url('event-thumb'); ?>"></a>
                    <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="event-details">
                        <span class="date"><i class="fa fa-calendar"></i><?php echo $date; ?></span>
                        <span class="location"><i class="fa fa-map-marker"></i><?php echo $location; ?></span>
                        <div class="description"><?php echo $description; ?></div>
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>
    </div>
</section>

<?php get_footer(); ?>
