<?php
    /* Template Name: Paper List */
?>
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

<section role="main" class="primary-content papers">
    <?php get_search_form(); ?>

    <?php
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $sortby = get_query_var('sortby') ? get_query_var('sortby') : 'date';
        $direction = get_query_var('direction') ? get_query_var('direction') : 'ASC';

        $title_link = '';
        $author_link = '';

        if ( $sortby == 'title' && $direction == 'ASC') {
            $title_link = add_query_arg(array('sortby' => 'title', 'direction' => 'DESC'), '/paper-index/');
        } else {
            $title_link = add_query_arg(array('sortby' => 'title', 'direction' => 'ASC'), '/paper-index/');
        }

        if ( $sortby == 'author' && $direction == 'ASC') {
            $author_link = add_query_arg(array('sortby' => 'author', 'direction' => 'DESC'), '/paper-index/');
        } else {
            $author_link = add_query_arg(array('sortby' => 'author', 'direction' => 'ASC'), '/paper-index/');
        }

        $args = array(
            'post_type' => 'papers',
            'order' => $direction,
            'orderby' => $sortby,
            'posts_per_page' => 5,
            'paged' => $paged
        );
        $papers = new WP_Query( $args);
    ?>

    <!-- <th><a href="<?php echo $title_link; ?>"><?= __('Title'); ?></a></th>
    <th><a href="<?php echo $author_link; ?>"><?= __('Author'); ?></a></th>
    <th><?= __('Keywords'); ?></th>
    <th><?= __('Abstract'); ?></th> -->
    <div class="paper-list">
        <?php
            while ( $papers->have_posts() ) : $papers->the_post();

            $pdf = types_render_field('paper-upload', array("raw" => true));
            $url = types_render_field('paper-url', array("raw" => true));
        ?>
            <article class="paper-item">
                <h2><?php the_title(); ?></h2>
                <div class="paper-meta">
                    <span class="author"><i class="fa fa-user"></i><?php echo bp_core_get_userlink($post->post_author); ?></span>
                    <span class="tags"><i class="fa fa-tags"></i><?php echo get_the_tag_list('',',',''); ?></span>
                    <?php if ( $pdf ) : ?>
                        <span class="download"><i class="fa fa-file-text"></i><a href="<?php echo $pdf; ?>">Download</a></span>
                    <?php elseif ($url) : ?>
                        <span class="paper-url"><i class="fa fa-link"></i><a href="<?php echo $url; ?>">View Paper</a></span>
                    <?php endif; ?>
                </div>
                <div class="abstract"><?php echo types_render_field('abstract', array("raw" => true)); ?></div>
            </article>
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
