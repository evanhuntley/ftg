<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <section class="section-header">
        <div class="container">
            <?php if ( is_front_page() ) { ?>
                <h1><?php the_title(); ?></h1>
            <?php } else if ( !bp_is_member()) { ?>
                <h1><?php the_title(); ?></h1>
            <?php } ?>
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

    <?php if ( bp_is_member()) : ?>
        <article role="main" class="primary-content type-profile">
    <?php else : ?>
        <article role="main" class="primary-content type-page" id="post-<?php the_ID(); ?>">
    <?php endif ; ?>

    <?php if ( !is_buddypress()) : ?>
    <div class="content-block">
        <?php the_content(); ?>
    </div>
    <?php else : ?>
        <?php the_content(); ?>
    <?php endif; ?>
    
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

    <?php endwhile; ?>

    <?php if ( !is_buddypress()) : ?>
    <aside class="secondary-content">
        <?php get_sidebar(); ?>
    </aside>
    <?php endif; ?>

    </article>


<?php get_footer(); ?>
