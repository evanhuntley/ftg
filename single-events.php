<?php get_header(); ?>

    <section class="section-header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ( !bp_is_user()) : ?>
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
            $terms = get_the_terms($post->ID, 'event-id');
            $participants = types_render_field("participant-list", array("html" => true));
            $rsvp = types_render_field("rsvp-form-url", array("raw" => true));

            if ( $terms ) {
                $event_id = array_pop($terms)->slug;
            }

            echo '<span class="event-id hidden">' . $event_id . '</span>';
        ?>
        <div class="event-image"><a href="<?= get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img src="<?php echo the_post_thumbnail_url('event-feature'); ?>"></a></div>
        <?php if ( $rsvp ) : ?>
            <div class="rsvp">
                <h3>Are You Coming?</h3>
                <a href="<?= $rsvp; ?>" class="btn btn-primary">RSVP Now</a>
            </div>
        <?php endif; ?>
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
            <?php 
                wp_reset_query();
                the_content(); 
            ?>
        </div>
        <?php if ( $participants) : ?>
            <div class="participants block">
                <h2>Participants</h2>
                <?php echo $participants; ?>
            </div>
        <?php endif; ?>
    </article>

<?php get_footer(); ?>
