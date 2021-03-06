<?php
	$pdf = types_render_field('paper-upload', array("raw" => true));
	$url = types_render_field('paper-url', array("raw" => true));
	$published_details = types_render_field('published-details', array("raw" => true));
	$additional_authors = types_render_field('additional-authors', array("raw" => true));
?>
<article class="paper-item">
<h2><a href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></h2>
<div class="paper-meta">
	<span class="author"><i class="fa fa-user"></i>
		<?php //echo bp_core_get_userlink($post->post_author); ?>
		<?php
			$first = true;
			if ( $additional_authors ) {
				$authors = explode(',', $additional_authors);
				foreach($authors as $author) {
					if ( !$first) {
						echo ', ';
					}
					echo check_for_author($author);
					$first = false;
				}
			}
		?>
	</span>
	<span class="date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>
	<?php if ( bp_is_my_profile() ) : ?>
		<span class="delete"><i class="fa fa-times"></i><a href="<?php echo get_delete_post_link( $post->ID ); ?>">Delete</a></span>
		<span class="edit"><i class="fa fa-pencil"></i>
			<?php do_action('gform_update_post/edit_link', array(
					'post_id' => $post->ID,
					'url'     => home_url('/edit-paper/'),
					'text'	  => 'Edit'
				) );
			?>
		</span>
	<?php endif; ?>
</div>
<div class="abstract">
	<?php
		$abstract = types_render_field('abstract', array("raw" => true));
		$more = '... <a href="' . get_the_permalink() . '">Read More</a>';
		echo wp_trim_words( $abstract, 20, $more );
	?>
</div>
<?php if ($published_details) : ?>
	<div class="published">Published: <?php echo $published_details; ?></div>
<?php endif; ?>
<?php if (get_the_tag_list()) : ?>
	<div class="tags"><?php echo get_the_tag_list('','',''); ?></div>
<?php endif; ?>

</article>
