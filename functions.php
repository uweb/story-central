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

add_action('save_post', 'update_cached_story_data');
function update_cached_story_data() {
    if (get_post_type($post) == "story") {
        global $json_api;

        $posts = get_posts(array(
            'posts_per_page'  => -1,
            'orderby'         => 'post_date',
            'post_type'       => 'story',
            'post_status'     => 'publish'
        ));

        foreach ($posts as $post) {
            $story_central = new stdClass();

            $post_meta = get_post_meta($post->ID);
            $excerpt = $post_meta['abstract'];

            $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , array(350,350) );
            $img_url = ( has_post_thumbnail( $post->ID ) ) ? reset( $img_src ) : '';

            $tag_slugs = array();
            $pillar_slugs = array();

            foreach (wp_get_post_tags($post->ID) as $tag) {
            array_push($tag_slugs, html_entity_decode($tag->slug));
            }

            foreach (((array)get_the_terms($post->ID, 'pillar')) as $pillar) {
                array_push($pillar_slugs, html_entity_decode($pillar->slug));
            }

            $story_central->{title}             = html_entity_decode($post->post_title);
            $story_central->{link}              = get_permalink($post->ID);
            $story_central->{tags}              = $tag_slugs;
            $story_central->{pillars}           = $pillar_slugs;
            $story_central->{image}             = $img_url;
            $story_central->{excerpt}           = $excerpt[0];
            $story_central->{content}           = $post->post_content;

            $story_central_posts[]                   = $story_central;
        }

        file_put_contents(get_stylesheet_directory() .
        '/data/story-central-cache.json'  , json_encode($story_central_posts) );
    }
}