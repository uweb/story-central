<?php
//widgets go here
//
//1) social widget that includes a social site as the title and a blurb appropriate for the platform
//2) links widget that is an array of links to related things, as many as necessary, starting with one
//3) authors widget that contains an array of authors.  Name, phone and email are fields for each author


function uw_story_register_widgets() {
    if (!is_blog_installed()){
        return;
    }

    register_widget('UW_Story_Social_Widget');
}

require(get_stylesheet_directory() . '/inc/widgets/uw_story_social_widget.php');
require( get_stylesheet_directory() . '/inc/widgets/gallery.php' );

add_action('widgets_init', 'uw_story_register_widgets');
