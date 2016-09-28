<section role="complementary" class="secondary-content">
    <?php if ( get_post_type() == 'page') {
        $post_ID = $post->ID;
        $menu = get_post_meta( get_the_ID(), 'meta-box-dropdown', true );
        if ( $menu && ($menu != '-- None --') && !is_search() ) {
            echo '<nav class="subnav">';
            if ( $menu == '-- Inherit --') {
                $parent_id = wp_get_post_parent_id( $post_ID );
                $new_menu = get_post_meta( $parent_id, 'meta-box-dropdown', true );

                while ( $new_menu == '-- Inherit --') {
                    $parent_id = wp_get_post_parent_id( $parent_id );
                    $new_menu = get_post_meta( $parent_id, 'meta-box-dropdown', true );
                }

                if ( $new_menu != '-- None --') {
                    wp_nav_menu( array('menu' => $new_menu, 'container' => ''));
                }

            } else {
                wp_nav_menu( array('menu' => $menu, 'container' => ''));
            }
            echo '</nav>';
        }
    }
    ?>
    <?php if( is_active_sidebar('sidebar-1') ) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>
</section>
