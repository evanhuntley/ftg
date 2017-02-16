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
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
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
function bbg_register_member_types_with_directory() {
    bp_register_member_type( 'voting-member', array(
        'labels' => array(
            'name'          => 'Voting Members',
            'singular_name' => 'Voting Member',
        ),
        'has_directory' => 'voting-members'
    ) );
	bp_register_member_type( 'senior-member', array(
        'labels' => array(
            'name'          => 'Senior Members',
            'singular_name' => 'Senior Member',
        ),
        'has_directory' => 'senior-members'
    ) );
	bp_register_member_type( 'fellow', array(
        'labels' => array(
            'name'          => 'Fellows',
            'singular_name' => 'Fellow',
        ),
        'has_directory' => 'fellows'
    ) );
}
add_action( 'bp_init', 'bbg_register_member_types_with_directory' );

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
    'show_all'        => true,
    'end_size'        => 1,
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

// Check if User has met Paper Limit
function paper_limit_met($user_ID) {

    $paper_annual_limit = 2;

    $current_year = date("Y");

    $args = array(
        'post_type' => 'papers',
        'author' => $user_ID,
        'year' => $current_year
    );

    $paper_query = new WP_Query( $args );

    if ($paper_query->post_count < $paper_annual_limit) {
        return false;
    } else {
        return true;
    }

}

// Check if author First/Last is user match
function check_for_author($author_name) {

    $args = array(
        'search'         => $author_name,
    	'search_columns' => array( 'display_name' )
    );

    $authors = new WP_User_Query( $args );

    if ($authors->get_total() > 0) {
        // Return ID for
        $id = $authors->get_results();
        $id2 = $id[0]->ID;
        return bp_core_get_userlink($id2);
    } else {
        return $author_name;
    }
}

// Get Cancelled/Expired Users
function get_active_users() {
    $args = array(
         'meta_key' => 'rcp_status',
         'meta_value' => 'active',
     );

     $userQuery = new WP_User_Query($args);
     $users_list = '';
     $i = 1;

     foreach($userQuery->results as $user) {
         $users_list .= $user->ID;
         if ($i < count($userQuery->results)) {
             $users_list .= ', ';
         }
         $i++;
     }

     return $users_list;
}

// Get "Old" News
function get_old_news() {
    $args = array(
        'post_type' => 'news',
        'posts_per_page' => -1
    );

    $news = new WP_Query($args);
    $past_items = [];

    while ( $news->have_posts() ) : $news->the_post();
        $end = types_render_field("news-end-date", array("raw" => true));

        if ($end < time() && $end != null) {
            array_push($past_items, get_the_id());
        }

    endwhile;

    return $past_items;
}

add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
    if( $form['id'] == '1' ) {
        $confirmation = array( 'redirect' => bp_loggedin_user_domain() . '#user-papers' );
    }
    return $confirmation;
}

function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

add_filter( 'protected_title_format', 'remove_protected_text' );
function remove_protected_text() {
	return __('%s');
}

add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
	' . __( "<p>Please enter the registration password to proceed.</p>" ) . '
	<label for="' . $label . '">' . __( "Registration Password" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
	</form>
	';
	return $o;
}

// Custom Image Sizes
add_action( 'after_setup_theme', 'ftg_theme_setup' );
function ftg_theme_setup() {
  add_image_size( 'event-feature', 600, 225, true ); // (cropped)
  add_image_size( 'event-thumb', 300, 300, true ); // (cropped)
}

// Menu Meta Box
function custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
        <div>
			<p><strong>Menu</strong></p>
            <label class="screen-reader-text" for="meta-box-dropdown">Menu</label>
            <select name="meta-box-dropdown">
				<option>-- Inherit --</option>
				<?php
					$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

					foreach ( $menus as $menu ) {

						if ( $menu->name == get_post_meta($object->ID, "meta-box-dropdown", true))
						{
						    ?>
						        <option selected><?php echo $menu->name; ?></option>
						    <?php
						}
						else {
							?>
						        <option><?php echo $menu->name; ?></option>
						    <?php
						}
					}
				?>
				<option>-- None --</option>
            </select>
        </div>
    <?php
}

function add_custom_meta_box()
{
    add_meta_box("demo-meta-box", "Subnavigation", "custom_meta_box_markup", "page", "side", "low", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");

function save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "page";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_dropdown_value = "";

    if(isset($_POST["meta-box-dropdown"]))
    {
        $meta_box_dropdown_value = $_POST["meta-box-dropdown"];
    }
    update_post_meta($post_id, "meta-box-dropdown", $meta_box_dropdown_value);
}

add_action("save_post", "save_custom_meta_box", 10, 3);

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

add_filter( 'gform_init_scripts_footer', '__return_true' );

function alphabetize_by_last_name( $bp_user_query ) {
    if ( 'last-name' == $bp_user_query->query_vars['type'] )
        $bp_user_query->uid_clauses['orderby'] = "ORDER BY substring_index(u.display_name, ' ', -1)";
}
add_action ( 'bp_pre_user_query', 'alphabetize_by_last_name' );

// add order options to members loop
function ch_member_order_options() {
?>
   <option value="last-name" selected="selected"><?php _e( 'Last Name', 'buddypress' ); ?></option>
<?php
}
add_action( 'bp_members_directory_order_options', 'ch_member_order_options' );


?>
