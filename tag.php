<?php get_header(); ?>

<section class="section-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
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

<?php
    $current_path = $_SERVER['REQUEST_URI'];
    $tag = single_tag_title("", false);
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $sortby = get_query_var('sortby') ? get_query_var('sortby') : 'date';
    $direction = get_query_var('direction') ? get_query_var('direction') : 'DESC';

    $title_link = '';
    $author_link = '';
    $date_link = '';

    if ( $sortby == 'title' && $direction == 'ASC') {
        $title_link = add_query_arg(array('sortby' => 'title', 'direction' => 'DESC'), $current_path);
    } else {
        $title_link = add_query_arg(array('sortby' => 'title', 'direction' => 'ASC'), $current_path);
    }

    if ( $sortby == 'author' && $direction == 'ASC') {
        $author_link = add_query_arg(array('sortby' => 'author', 'direction' => 'DESC'), $current_path);
    } else {
        $author_link = add_query_arg(array('sortby' => 'author', 'direction' => 'ASC'), $current_path);
    }

    if ( $sortby == 'date' && $direction == 'ASC') {
        $date_link = add_query_arg(array('sortby' => 'date', 'direction' => 'DESC'), $current_path);
    } else {
        $date_link = add_query_arg(array('sortby' => 'date', 'direction' => 'ASC'), $current_path);
    }
?>

<section role="main" class="primary-content papers">
    <?php
        $direction_string = '';

        if ($sortby == 'date' && $direction == 'DESC') {
            $direction_string = 'newest first';
        } else if ($sortby == 'date' && $direction == 'ASC') {
            $direction_string = 'oldest first';
        } else if ($direction == 'ASC') {
            $direction_string = 'A - Z';
        } else {
            $direction_string = 'Z - A';
        }

        $args = array(
            'post_type' => 'papers',
            'order' => $direction,
            'orderby' => $sortby,
            'posts_per_page' => 5,
            'tag' => $tag,
            'paged' => $paged
        );
        $papers = new WP_Query( $args);
    ?>

    <aside class="filters">
        <?php get_search_form(); ?>
        <ul>
            <li><a href="<?php echo $title_link; ?>"><?= __('Sort by Title'); ?></a></li>
            <li><a href="<?php echo $author_link; ?>"><?= __('Sort by FTG Member'); ?></a></li>
            <li><a href="<?php echo $date_link; ?>"><?= __('Sort by Submission Date'); ?></a></li>
            <li><a href="/paper-index/"><?= __('View All Papers'); ?></a></li>
        </ul>
        <?php echo get_the_tag_list('<p>Tags:</p><ul><li>', '</li><li>', '</li></ul>'); ?>
    </aside>

    <div class="paper-list content-block">
        <?php if ( $sortby != '' && $direction != '') : ?>
            <div class="sort-notice">Showing papers sorted by <?= $sortby; ?>, <?= $direction_string; ?>.</div>
        <?php endif; ?>

        <?php while ( $papers->have_posts() ) : $papers->the_post(); ?>
            <?php get_template_part( 'loop', 'papers' ); ?>
        <?php endwhile; ?>
    </div>

    <!-- pagination here -->
    <?php
      if (function_exists(custom_pagination)) {
        custom_pagination($papers->max_num_pages,"",$paged);
      }
    ?>

  <?php wp_reset_postdata(); ?>
</section>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>
