<?php get_header(); ?>

<?php
	if ( have_posts() )
		the_post();
?>
<section class="section-header">
	<div class="container">
		<h1>
		    <?php _e( 'News' ); ?>
		</h1>
	</div>
</section>

	<?php
		$args = array(
			'post_type' => 'news',
			'posts_per_page' => 10,
			'orderby' => 'meta_value',
			'meta_key' => 'wpcf-news-announcement-date',
			'post__not_in' => get_old_news()
		);
		$news = new WP_Query( $args);
	?>

	<?php
		$date = types_render_field("news-announcement-date", array("format" => "M j, Y"));
	?>

	<?php while ( $news->have_posts() ) : $news->the_post(); ?>
		<div class="container news-list">
			<article class="news-item">
				<h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="date"><?php echo $date; ?></div>
			</article>
		</div>
	<?php endwhile; ?>

<?php get_footer(); ?>
