<?php
/*
Controller name: Story Central
Controller description: Necessary json for the story central requests
*/

class json_api_story_central_posts_controller
{
  public function get_all_story_central_posts() {
    global $json_api;

    $transient_name = 'get_all_story_central_posts';

    $data_timeout = get_option('_transient_timeout_' . $transient_name);
    $transient = ($data_timeout < time()) ? false : true ;

    if ($transient == true) {
        $story_central_posts = get_transient($transient_name);
    } else {
      $posts = $json_api->introspector->get_posts(array(
        'posts_per_page'  => -1,
        'orderby'         => 'post_date',
        'post_type'       => 'story',
        'post_status'     => 'publish'
      ));

      foreach ($posts as $post) {
        $story_central = new stdClass();

        $custom_fields = $post->custom_fields;
        $excerpt = $custom_fields->abstract;

        $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , array(350,350) );
        $img_url = ( has_post_thumbnail( $post->ID ) ) ? reset( $img_src ) : '';

        $tag_slugs = array();
        $pillar_slugs = array();

        foreach ($post->tags as $tag) {
          array_push($tag_slugs, html_entity_decode($tag->slug));
        }

        foreach ($post->taxonomy_pillar as $pillar) {
            array_push($pillar_slugs, html_entity_decode($pillar->slug));
        }

        $story_central->{title}             = html_entity_decode($post->title);
        $story_central->{link}              = $post->url;
        $story_central->{tags}              = $tag_slugs;
        $story_central->{pillars}           = $pillar_slugs;
        $story_central->{image}             = $img_url;
        $story_central->{excerpt}           = $excerpt[0];
        $story_central->{content}           = $post->content;

        $story_central_posts[]                   = $story_central;
      }
      set_transient($transient_name, $story_central_posts, 48 * HOUR_IN_SECONDS);
    }

    return $this->posts_object_result($story_central_posts , null);
  }

  public function error() {
    global $json_api;
    $json_api->error("That method does not exist");
  }

  protected function posts_object_result($posts) {
    return array(
      'count' => count($posts),
      'posts' => $posts
    );
  }
}

?>