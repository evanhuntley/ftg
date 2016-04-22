<?php
    /* Template Name: Home Page */
?>
<?php get_header(); ?>

<section class="section-header home-hero">
    <div class="container">
        <div class="hero-copy">
            <h1>We Know Finance</h1>
            <p>Now get to know us...</p>
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
                    'posts_per_page' => 3,
                    'post__not_in' => $premium_ids,
                    'orderby' => 'meta_value',
                    'meta_key'  => 'wpcf-event-date',
                    'order' => 'DESC'
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
        <section class="featured-work">
            <?php
                $args = array(
                    'post_type' => 'papers',
                    'order' => RAND,
                    'orderby' => $sortby,
                    'posts_per_page' => 5,
                    'paged' => $paged
                );
                $papers = new WP_Query( $args);
            ?>

            <div class="paper-list">
            <?php
                while ( $papers->have_posts() ) : $papers->the_post();
            ?>
                <?php the_title(); ?>
            <?php endwhile; ?>
            </div>
        </section>
    </div>
</section>

<section class="featured-members">
    <div class="container">
        <?php
            $args = array( 'type' => 'random', 'max' => 3, 'meta_key' => 'ftg_user_uploaded_avatar', 'meta_value' => 1 );
            if ( bp_has_members( $args ) ) : ?>
                <?php while ( bp_members() ) : bp_the_member(); ?>
                    <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar('type=full&width=125&height=125') ?></a>
                <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>
