<?php get_header(); ?>

<?php
    $slug = $wp_query->queried_object->name;
?>

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
        	if ( have_posts() )
        		the_post();
        ?>

            <?php
                // Only show the appopriate events based on permissions.
                if ( !rcp_is_active() ) {
                    $premium_ids = rcp_get_paid_posts();
                } else {
                    $premium_ids = array();
                }

                $args = array(
                    'post_type' => 'events',
                    'orderby' => 'meta_value',
                    'meta_key'  => 'wpcf-event-date',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'post__not_in' => $premium_ids,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'event-category',
                            'field'    => 'slug',
                            'terms'    => $slug,
                        ),
                    ),
                );
                $posts = query_posts( $args);
            ?>

            <ul class="events-list">
            <?php
                while ( have_posts() ) : the_post();

                $date = types_render_field("event-date", array("format" => "M j, Y"));
                $start_date = types_render_field("event-date", array("format" => "M j"));
                $end_date = types_render_field("end-date", array("format" => "M j, Y"));
                $location = types_render_field("location-short-name", array("raw" => true));
                $description = types_render_field("event-short-description", array("raw" => true));
            ?>
                <li>
                    <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo the_post_thumbnail_url('event-thumb'); ?>"></a>
                    <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="event-details">
                        <span class="date"><i class="fa fa-calendar"></i>
                            <?php
                                if ( $end_date ) {
                                    echo $start_date . ' - ' . $end_date;
                                } else {
                                    echo $date;
                                }
                            ?>
                        </span>
                        <span class="location"><i class="fa fa-map-marker"></i><?php echo $location; ?></span>
                        <div class="description"><?php echo $description; ?></div>
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>
    </div>
</section>

<?php get_footer(); ?>
