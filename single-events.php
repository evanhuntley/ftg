<?php get_header(); ?>

    <section class="section-header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ( !bp_is_member()) : ?>
    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
        <div class="container">
            <?php if(function_exists('bcn_display'))
            {
                bcn_display();
            }?>
        </div>
    </div>
    <?php endif; ?>

    <article role="main" class="primary-content type-event" id="post-<?php the_ID(); ?>">

        <?php
            $date = types_render_field("event-date", array("format" => "M j, Y"));
            $start_date = types_render_field("event-date", array("format" => "M j"));
            $end_date = types_render_field("end-date", array("format" => "M j, Y"));
            $location = types_render_field("location-full", array("raw" => false));
            $description = types_render_field("event-short-description", array("raw" => true));
            $form_id = types_render_field("rsvp-form-id", array("raw" => true));
            $terms = get_the_terms($post->ID, 'event-id');
            $participants = types_render_field("participant-list", array("html" => true));

            if ( $terms ) {
                $event_id = array_pop($terms)->slug;
            }

            echo '<span class="event-id hidden">' . $event_id . '</span>';

            // Check for prior RSVP
            $args = array(
                'post_type' => 'attendance',
                'author' => bp_loggedin_user_id(),
                'tax_query' => array(
            		array(
            			'taxonomy' => 'event-id',
            			'field'    => 'slug',
            			'terms'    => $event_id,
            		),
            	),
            );
            $rsvps = new WP_Query( $args);

            $rsvp_ID = $rsvps->posts[0]->ID;

            if ( $form_id && $rsvps->post_count > 0) {
                echo do_shortcode('[gravityform id="' . $form_id . '" ajax=true update="' . $rsvp_ID .'"]');
            } elseif ( $form_id ) {
                echo do_shortcode('[gravityform id="' . $form_id . '" ajax=true]');
            }

            wp_reset_query();
            ?>
        <div class="event-image"><a href="<?= get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img src="<?php echo the_post_thumbnail_url('event-feature'); ?>"></a></div>
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
            <span class="location"><?= $location; ?></span>
            <div class="description"><?php echo $description; ?></div>
        </div>
        <div class="content">
            <?php the_content(); ?>
        </div>
        <?php if ( $participants) : ?>
            <div class="participants block">
                <h2>Participants</h2>
                <?php echo $participants; ?>
            </div>
        <?php endif; ?>
    </article>

<?php get_footer(); ?>
