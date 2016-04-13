<?php
    /* Template Name: Paper List */
?>
<?php get_header(); ?>

<section class="section-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<article role="main" class="primary-content papers">
    <?php get_search_form(); ?>
    <a href="<?php echo add_query_arg(array('sortby' => 'title', 'direction' => 'ASC'), '/papers/'); ?>">Title Ascending</a>
    <a href="<?php echo add_query_arg(array('sortby' => 'title', 'direction' => 'DESC'), '/papers/'); ?>">Title Descending</a>
    <a href="<?php echo add_query_arg(array('sortby' => 'author', 'direction' => 'ASC'), '/papers/'); ?>">Author Ascending</a>
    <a href="<?php echo add_query_arg(array('sortby' => 'author', 'direction' => 'DESC'), '/papers/'); ?>">Author Descending</a>
    <table>
        <thead>
            <tr>
                <th><?= __('Title'); ?></th>
                <th><?= __('Author'); ?></th>
                <th><?= __('Keywords'); ?></th>
                <th><?= __('Abstract'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $sortby = get_query_var('sortby') ? get_query_var('sortby') : 'date';
            $direction = get_query_var('direction') ? get_query_var('direction') : 'ASC';

            $args = array(
                'post_type' => 'papers',
                'order' => $direction,
                'orderby' => $sortby,
                'posts_per_page' => 5,
                'paged' => $paged
            );
            $papers = new WP_Query( $args);
            while ( $papers->have_posts() ) : $papers->the_post();
        ?>
            <tr>
                <td><?php the_title(); ?></td>
                <td><?php echo get_the_author(); ?></td>
                <td><?php echo get_the_tag_list(); ?></td>
                <td><?php echo types_render_field('abstract', array("raw" => true)); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- pagination here -->
    <?php
      if (function_exists(custom_pagination)) {
        custom_pagination($papers->max_num_pages,"",$paged);
      }
    ?>

  <?php wp_reset_postdata(); ?>
</article>

<?php get_footer( 'no-sidebar' ); // will include footer-no-sidebar.php; ?>
