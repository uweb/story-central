<?php
class UW_Story_Central
{
    function UW_Story_Central()
    {
        require( get_stylesheet_directory() . '/inc/widgets.php' );
        require( get_stylesheet_directory() . '/inc/post-type-story.php' );
        require( get_stylesheet_directory() . '/inc/template-functions.php' );

        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 9 );
    }

    function scripts()
    {
        require( get_stylesheet_directory() . '/setup/scripts.php' );
    }

}

new UW_Story_Central;
