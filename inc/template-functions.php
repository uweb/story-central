<?php

function get_pillars()
{
  return get_terms('pillar', 'orderby=none&hide_empty');
}

function get_stories_with_pillar( $pillar, $num_posts=-1 )
{
    return get_posts(array(
        'post_type' => 'story',
        'tax_query' => array(
            array(
                'taxonomy' => 'pillar',
                'field' => 'term_id',
                'terms' => $pillar
            )
        ),
        'posts_per_page' => $num_posts
    ) );
}

function get_promoted_story($pillar=false) {
    $args = array(
        'post_type' => 'story',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'order' => 'DESC',
        'order_by' => 'date',
        'promoted' => 1
    );
    if (!empty($pillar)) {
        $args['pillar'] = $pillar->slug;
    }
    $query = new WP_Query($args);
    return $query->posts[0];
}


/**
  * Twitter section html
  */
function the_twitter_section( $post_id )
{
  echo get_the_twitter_section( $post_id );
}
function get_the_twitter_section( $post_id )
{
  $twitter = (object) get_post_meta($post_id, 'twitter', true );

  if ( ! $twitter->tweet ) return;

  $html = '<div class="widget uw-story-social">
            <h3 class="widget-title">Twitter</h3>
            <div class="twitter-widget">
              <div class="social-head">
                <img src="'. get_stylesheet_directory_uri() .'/img/social.jpg">
                <span>University of Washington</span><p>'. $twitter->tweet .'</p>
              </div>
           </div>
          </div>';

  return story_section( $html );
}

/**
* Facebook section HTML
*/

function the_facebook_section( $post_id )
{
    echo get_the_facebook_section( $post_id );
}

function get_the_facebook_section( $post_id )
{

  $facebook = (object) get_post_meta( $post_id, 'facebook', true );

  if ( ! $facebook->post ) return;

  $html = '<div class="widget uw-story-social">
            <h3 class="widget-title">Facebook</h3>
            <div class="facebook-widget">
              <div class="social-head">
                <img src="'. get_stylesheet_directory_uri() .'/img/social.jpg">
                <span>University of Washington</span><p>'. apply_filters('the_content', $facebook->post ) .'</p>
              </div>
            </div>
          </div>';

  return story_section( $html );

}


/**
* External link section
*/

function the_external_links_section( $post_id )
{
  echo get_the_external_links_section( $post_id );
}

function get_the_external_links_section( $post_id )
{
  $external = (String) get_post_meta( $post_id, 'links', true );

  if ( ! $external ) return;

  $html = '<div class="widget">
            <h3 class="widget-title">Related Links</h3>
            <p>'. $external .'</p>
          </div>';

  return story_section( $html );

}


/**
* External link section
*/

function the_original_authors_section( $post_id )
{
  echo get_the_original_authors_section( $post_id );
}

function get_the_original_authors_section( $post_id )
{
  $authors = (String) get_post_meta( $post_id, 'authors', true );

  if ( ! $authors ) return;

  $html = '<div class="widget">
            <h3 class="widget-title">Original authors</h3>
            <p>'. $authors .'</p>
          </div>';

  return story_section( $html );

}


function story_section( $html )
{
  return '<div class="block-row">
          <div class="block-full first-block last-block">
            ' . $html . '
          </div>
        </div>';
}

/*
 * The following section is for getting image assets, in one form or another
 * 
 */
//this function is useless until we are returning HTML to print out
function the_media_gallery_section( $post_id )
{
    echo get_the_media_gallery_section( $post_id );
}

function get_the_media_gallery_section( $post_id )
{
    $media = (String) get_post_meta($post_id, 'gallery', true);
    $html = '<div class="widget story-gallery">' . do_shortcode('[gallery ids="'. $media .'"]') . '</div>';
    return story_section( $html );
}

//this simply returns the array of attachment IDs
function get_the_media_gallery_array( $post_id ){
    $media = (String) get_post_meta($post_id, 'gallery', true);
    $media_arr = '';
    if (!empty($media)) {
        $media_arr = explode(',' , $media);
    }
    return $media_arr;
}

//this uses the above function to return an attachement url
function get_media_gallery_featured_image_url( $post_id ) {
    $media_arr = get_the_media_gallery_array( $post_id );
    $url = '';                      //can set a default story image here
    if (!empty($media_arr)){
        $image_id = $media_arr[0];
        $url = wp_get_attachment_url($image_id);
    }
    return $url;
}

function get_story_featured_image_url( $post_id ) {
    $image_id = get_post_thumbnail_id( $post_id);
    $url = wp_get_attachment_image_src( $image_id );
    return $url;
}
