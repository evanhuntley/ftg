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
	<div class="user-papers" id="user-papers">
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
		            while ( $papers->have_posts() ) : $papers->the_post(); ?>

					<?php get_template_part( 'loop', 'papers' ); ?>

		        <?php endwhile; ?>
			</div>
		<?php else : ?>
			<?php if ( bp_is_my_profile() ) : ?>
				<p>You haven't added any papers yet.</p>
			<?php else : ?>
				<p>This user has not added any papers yet.</p>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( bp_is_my_profile() && !paper_limit_met(bp_displayed_user_id())) : ?>
			<a class="btn" href="<?php echo site_url(); ?>/add-paper">Add a Paper</a>
		<?php elseif ( bp_is_my_profile()) : ?>
			<p class="info"><i class="fa fa-info-circle"></i>Note: You have already added two papers for this calendar year.  To add another, you must remove one of your <?php echo date('Y'); ?> submissions.</p>
		<?php endif; ?>
		</div>
	<?php
	/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
	do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>
