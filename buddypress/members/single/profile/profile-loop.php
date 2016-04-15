<?php
/**
 * BuddyPress - Members Profile Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

				<h4><?php bp_the_profile_group_name(); ?></h4>

				<div class="profile-fields">

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<?php if ( bp_field_has_data() ) : ?>

							<div<?php bp_field_css_class(); ?>>

								<div class="label"><?php bp_the_profile_field_name(); ?></div>

								<div class="data"><?php echo strip_tags(bp_the_profile_field_value()); ?></div>
							</div>

						<?php endif; ?>

						<?php

						/**
						 * Fires after the display of a field table row for profile data.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>

				</div>
			</div>

			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>
	<div class="user-papers">
	    <h4><?= __('Featured Work'); ?></h4>
	        <?php
	            $args = array(
	                'post_type' => 'papers',
	                'author' => bp_displayed_user_id()
	            );
	            $papers = new WP_Query( $args);
				if ( $papers->have_posts() ) :
			?>
				<div class="paper-list">
				<?php
		            while ( $papers->have_posts() ) : $papers->the_post();

					$pdf = types_render_field('paper-upload', array("raw" => true));
		        ?>
				<article class="paper-item">
	                <h2><?php the_title(); ?></h2>
	                <div class="paper-meta">
	                    <span class="tags"><i class="fa fa-tags"></i><?php echo get_the_tag_list('',',',''); ?></span>
	                    <span class="download"><i class="fa fa-file-text"></i><a href="<?php echo $pdf; ?>">Download</a></span>
						<?php if ( bp_is_my_profile() ) : ?>
							<span class="delete"><i class="fa fa-times"></i><a href="<?php echo get_delete_post_link( $post->ID ); ?>">Delete</a></span>
						<?php endif; ?>
	                </div>
	                <div class="abstract"><?php echo types_render_field('abstract', array("raw" => true)); ?></div>
	            </article>
		        <?php endwhile; ?>
			</div>
		<?php else : ?>
			<?php if ( bp_is_my_profile() ) : ?>
				<p>You haven't added any papers yet.</p>
				<a class="btn" href="<?php echo site_url(); ?>/add-paper">Add a Paper</a>
			<?php else : ?>
				<p>This user has not added any papers yet.</p>
			<?php endif; ?>
		<?php endif; ?>
			<?php if ( bp_is_my_profile() ) : ?>
	        	<a class="btn" href="<?php echo site_url(); ?>/add-paper">Add a Paper</a>
			<?php endif; ?>
		</div>
	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
	do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>
