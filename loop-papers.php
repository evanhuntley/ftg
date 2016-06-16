<?php
	$pdf = types_render_field('paper-upload', array("raw" => true));
	$url = types_render_field('paper-url', array("raw" => true));
	$published_details = types_render_field('published-details', array("raw" => true));
	$additional_authors = types_render_field('additional-authors', array("raw" => true));
?>
<article class="paper-item">
<h2><?php the_title(); ?></h2>
<div class="paper-meta">
	<span class="author"><i class="fa fa-user"></i>
		<?php echo bp_core_get_userlink($post->post_author); ?>
		<?php
			if ( $additional_authors ) {
				$authors = explode(',', $additional_authors);
				foreach($authors as $author) {
					echo ', ';
					echo check_for_author($author);
				}
			}
		?>
	</span>
	<?php if (get_the_tag_list()) : ?>
		<span class="tags"><i class="fa fa-tags"></i><?php echo get_the_tag_list('',',',''); ?></span>
	<?php endif; ?>
		<span class="date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>
	<?php if ( $pdf ) : ?>
		<span class="download"><i class="fa fa-file-text"></i><a href="<?php echo $pdf; ?>">Download</a></span>
	<?php elseif ($url) : ?>
		<span class="paper-url"><i class="fa fa-link"></i><a href="<?php echo $url; ?>">View Paper</a></span>
	<?php endif; ?>
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
	<span class="paper-id">
	<?php
		$id = get_the_id();
		echo 'ID: ' . sprintf('%05d', $id);
	?>
	</span>
</div>
<div class="abstract"><?php echo types_render_field('abstract', array("raw" => true)); ?></div>
<?php if ($published_details) : ?>
	<div class="published">Published: <?php echo $published_details; ?></div>
<?php endif; ?>

</article>
