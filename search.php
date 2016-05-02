<?php get_header(); ?>

<section class="section-header home-hero">
    <div class="container">
        <h1><?php printf( __( 'Search Results for: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </div>
</section>

<?php if ( have_posts() ) : ?>
    <article role="main" class="primary-content type-page search">
        <div class="paper-list">
        <?php get_template_part( 'loop', 'papers' ); ?>
		<?php else : ?>
            <h1 class="entry-title"><?php _e( 'Nothing Found' ); ?></h1>
            <article class="entry-content">
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.' ); ?></p>
                <?php /*?><?php get_search_form(); ?><?php */?>
            </article><!-- .entry-content -->
        <?php endif; ?>
        </div>
    </article>
<?php get_footer(); ?>
