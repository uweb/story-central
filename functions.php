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

function add_story_central_posts_controller($controllers) {
    $controllers[] = 'story_central_posts';
    return $controllers;
}
add_filter('json_api_controllers', 'add_story_central_posts_controller');

function set_story_central_posts_controller_path() {
    return dirname(__FILE__) . "/inc/story-central-json.php";
}
add_filter('json_api_story_central_posts_controller_path', 'set_story_central_posts_controller_path');

add_action( 'save_post', 'bust_story_central_transient');
function bust_story_central_transient() {
    global $post;
    if (get_post_type($post) == "story") {
        delete_transient('get_all_story_central_posts');
    }
}
