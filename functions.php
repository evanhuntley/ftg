<?php

/**
 * Add HTML5 theme support.
 */
function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );

add_theme_support( 'menus' );

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<aside>',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));

add_post_type_support('page', 'excerpt');

function post_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>

			<p class="comment-meta">
				<?php printf( __( '%s' ), sprintf( '%s', get_comment_author_link() ) ); ?>

                <a class="comment-date" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                    <?php printf( __( '%1$s' ), get_comment_date() ); ?>
                </a>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
                <?php endif; ?>
            </p>
		</div>

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	</div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>

	<li class="post pingback">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)' ), ' ' ); ?></p>
	<?php

		break;
	endswitch;
}

// Custom functions

// Tidy up the <head> a little. Full reference of things you can show/remove is here: http://rjpargeter.com/2009/09/removing-wordpress-wp_head-elements/
remove_action('wp_head', 'wp_generator');// Removes the WordPress version as a layer of simple security

add_theme_support('post-thumbnails');

// REMOVE EXTRANEOUS CLASSES FROM WORDPRESS MENUS - siteart.co.uk/remove-extraneous-classes-from-wordpress-menus
function custom_wp_nav_menu($var) {
        return is_array($var) ? array_intersect($var, array(
                // List of useful classes to keep
                'current_page_item',
                'current_page_parent',
                'current_page_ancestor'
                )
        ) : '';
}
add_filter('nav_menu_css_class', 'custom_wp_nav_menu');
add_filter('nav_menu_item_id', 'custom_wp_nav_menu');
add_filter('page_css_class', 'custom_wp_nav_menu');

// REPLACE "current_page_" WITH CLASS "active"
function current_to_active($text){
        $replace = array(
                // List of classes to replace with "active"
                'current_page_item' => 'active',
                'current_page_parent' => 'active',
                'current_page_ancestor' => 'active',
        );
        $text = str_replace(array_keys($replace), $replace, $text);
                return $text;
        }
add_filter ('wp_nav_menu','current_to_active');

// Set Buddypress Member Types
function bbg_register_member_types() {
    bp_register_member_type( 'member', array(
        'labels' => array(
            'name'          => 'Members',
            'singular_name' => 'Member',
        ),
    ) );
	bp_register_member_type( 'senior-member', array(
        'labels' => array(
            'name'          => 'Senior Members',
            'singular_name' => 'Senior Member',
        ),
    ) );
	bp_register_member_type( 'fellow', array(
        'labels' => array(
            'name'          => 'Fellows',
            'singular_name' => 'Fellow',
        ),
    ) );
}
add_action( 'bp_init', 'bbg_register_member_types' );

// Admin Bar - Only for Admin
if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}

// Custom Query Vars for Paper Filters
function custom_query_vars_filter($vars) {
  $vars[] = 'sortby';
  $vars[] .= 'direction';
  return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );


// Custom Pagination for Papers List
function custom_pagination($numpages = '', $pagerange = '', $paged='') {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   *
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  /**
   * We construct the pagination arguments to enter into our paginate_links
   * function.
   */
  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);

  if ($paginate_links) {
    echo "<nav class='custom-pagination'>";
      echo "<span class='page-numbers page-num'>Page " . $paged . " of " . $numpages . "</span> ";
      echo $paginate_links;
    echo "</nav>";
  }

}

// Disable Default Buddypress Styles
function my_dequeue_bp_styles() {
	wp_dequeue_style( 'bp-legacy-css' );
}
add_action( 'wp_enqueue_scripts', 'my_dequeue_bp_styles', 20 );

// Remove Link in Profile Fields
function remove_xprofile_links() {
    remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}
add_action( 'bp_init', 'remove_xprofile_links' );

/* if a user uploads an avatar we store a meta */
function ftg_user_uploaded_avatar(){
	$user_id = bp_displayed_user_id();
	if( !empty( $user_id ) )
		update_user_meta( $user_id, 'ftg_user_uploaded_avatar', 1 );
}
add_action( 'xprofile_avatar_uploaded', 'ftg_user_uploaded_avatar');

/* if a user deletes an avatar we delete the meta */
function ftg_user_deleted_avatar( $args ) {
	$user_id = bp_displayed_user_id();

	if( !empty( $user_id ) )
		delete_user_meta( $user_id, 'ftg_user_uploaded_avatar' );
}
add_action( 'bp_core_delete_existing_avatar', 'ftg_user_deleted_avatar', 10, 1 );

?>
