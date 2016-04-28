<?php
    /* Template Name: Home Page */
?>
<?php get_header(); ?>

<?php
    $main_title = types_render_field('hero-main-title', array("raw" => true));
    $subtitle = types_render_field('hero-subtitle', array("raw" => true));
?>

<section class="section-header home-hero">
    <div class="container">
        <div class="hero-copy">
            <h1><?= $main_title; ?></h1>
            <p><?= $subtitle; ?></p>
        </div>
    </div>
</section>

<section class="featured-content">
    <div class="container">
        <section class="featured-event">
            <?php
                // Only show the appopriate events based on permissions.
                if ( !rcp_is_active() ) {
                    $premium_ids = rcp_get_paid_posts();
                } else {
                    $premium_ids = [];
                }

                $args = array(
                    'post_type' => 'events',
                    'posts_per_page' => 1,
                    'post__not_in' => $premium_ids,
                    'orderby' => 'meta_value',
                    'meta_key'  => 'wpcf-event-date',
                    'order' => 'DESC'
                );
                $events = new WP_Query( $args);

                $date = get_post_meta($events->get_posts()[0]->ID, 'wpcf-event-date', true);
            ?>
            <?php if (rcp_is_active() && ($date > time())) : ?>
                <h2>Upcoming Meeting</h2>
            <?php else : ?>
                <h2>Our Latest Meeting</h2>
            <?php endif; ?>
            <?php
                while ( $events->have_posts() ) : $events->the_post();

                $description = types_render_field("event-short-description", array("raw" => true));
                $date = types_render_field("event-date", array("format" => "M j, Y"));
                $location = types_render_field("location-short-name", array("raw" => true));
            ?>
                <a href="<?= get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img src="<?php echo the_post_thumbnail_url('event-feature'); ?>"></a>
                <span class="date"><?= $date; ?></date>
                <span class="location"><?= $location; ?></date>
                <div class="description"><?php echo $description; ?></div>
            <?php endwhile; ?>
            <a class="btn" href="/ftg-events/">View all events</a>
        </section>
        <section class="featured-work">
            <h2>Recent Work</h2>
            <?php
                $args = array(
                    'post_type' => 'papers',
                    'orderby' => 'date',
                    'posts_per_page' => 2
                );
                $papers = new WP_Query( $args);
            ?>

            <div class="paper-list">
            <?php
                while ( $papers->have_posts() ) : $papers->the_post();
            ?>
                <?php get_template_part('loop', 'papers'); ?>
            <?php endwhile; ?>
            </div>
        </section>
    </div>
</section>

<section class="featured-members">
    <div class="container">
        <h2>Our Members</h2>
        <?php
            $args = array( 'type' => 'random', 'max' => 3, 'meta_key' => 'ftg_user_uploaded_avatar', 'meta_value' => 1 );
            if ( bp_has_members( $args ) ) : ?>
                <?php while ( bp_members() ) : bp_the_member(); ?>
                    <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar('type=full&width=125&height=125') ?></a>
                <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
