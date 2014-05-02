<?php
class UW_Story_Central {
    function UW_Story_Central() {
        require( get_stylesheet_directory() . '/inc/widgets.php' );
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 9 );
    }

    function scripts() {
        require( get_stylesheet_directory() . '/inc/scripts.php' );
    }
}
new UW_Story_Central;
