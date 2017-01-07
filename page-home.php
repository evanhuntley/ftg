<?php
    /* Template Name: Home Page */
?>
<?php get_header(); ?>

<?php
    $main_title = types_render_field('hero-main-title', array("raw" => true));
?>

<section class="section-header home-hero">
    <div class="container">
        <div class="hero-copy">
            <h1><?= $main_title; ?></h1>
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
                    $premium_ids = array();
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

                $idArray =  $events->get_posts();
                $id = $idArray[0]->ID;

                $date = get_post_meta($id, 'wpcf-event-date', true);
            ?>
            <?php if (rcp_is_active() && ($date > time())) : ?>
                <h2>Upcoming Event</h2>
            <?php else : ?>
                <h2>Our Latest Event</h2>
            <?php endif; ?>
            <?php
                while ( $events->have_posts() ) : $events->the_post();

                $description = types_render_field("event-short-description", array("raw" => true));
                $date = types_render_field("event-date", array("format" => "M j, Y"));
                $start_date = types_render_field("event-date", array("format" => "M j"));
                $end_date = types_render_field("end-date", array("format" => "M j, Y"));
                $location = types_render_field("location-short-name", array("raw" => true));
            ?>
            <div class="event">
                <a href="<?= get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img src="<?php echo the_post_thumbnail_url('event-feature'); ?>"></a>
                <h2><a href="<?= get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h2>
                <span class="date"><i class="fa fa-calendar"></i>
                    <?php
                        if ( $end_date ) {
                            echo $start_date . ' - ' . $end_date;
                        } else {
                            echo $date;
                        }
                    ?>
                </span>
                <span class="location"><i class="fa fa-map-marker"></i><?= $location; ?></span>
                <div class="description"><?php echo $description; ?></div>
            </div>
            <?php endwhile; ?>
            <a class="btn alt" href="/ftg-events/">View all events</a>
        </section>
        <section class="featured-news">
            <h2>Recent News</h2>
            <?php
                $args = array(
                    'post_type' => 'news',
                    'posts_per_page' => 3,
                    'orderby' => 'meta_value',
                    'meta_key' => 'wpcf-news-announcement-date',
                    'post__not_in' => get_old_news()
                );
                $news = new WP_Query( $args);
            ?>

            <div class="news-list">
            <?php
                while ( $news->have_posts() ) : $news->the_post();

                $date = types_render_field("news-announcement-date", array("format" => "M j, Y"));
            ?>
                <div class="news-item">
                    <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="date"><?php echo $date; ?></div>
                </div>
            <?php endwhile; ?>
            </div>
            <a class="btn alt" href="/news/">View all news</a>
        </section>
    </div>
</section>

<section class="featured-members">
    <div class="container">
        <h2>Featured Members</h2>
        <?php
            $active = get_active_users();

            $args = array(
                'type' => 'random',
                'max' => 3,
                'member_type' => array( 'voting-member', 'senior-member', 'fellow' ),
                'meta_key' => 'ftg_user_uploaded_avatar',
                'meta_value' => 1,
                'include' => $active
            );
            if ( bp_has_members( $args ) ) : ?>
            <ul class="members-list">
            <?php while ( bp_members() ) : bp_the_member(); ?>

                <li <?php bp_member_class(); ?>>
                    <div class="item-avatar">
                        <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=full&height=150&width=150'); ?></a>
                    </div>

                    <div class="item">
                        <div class="item-title">
                            <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                        </div>
                        <div class="university">
                            <?php if (bp_get_member_profile_data('field=Institution')) : ?>
                                <?php echo bp_get_member_profile_data('field=Institution'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
