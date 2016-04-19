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


<section class="featured-members">
    <div class="container">
        <?php if ( bp_has_members( 'type=random&max=3' ) ) : ?>
                <?php while ( bp_members() ) : bp_the_member(); ?>
                    <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar('type=full&width=125&height=125') ?></a>
                <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>
