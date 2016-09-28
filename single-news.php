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

    <article role="main" class="primary-content single-news" id="post-<?php the_ID(); ?>">
        <div class="content">
            <div class="date"><?php echo get_the_date(); ?></div>
            <?php
                wp_reset_query();
                the_content();
            ?>
        </div>
    </article>

<?php get_footer(); ?>
