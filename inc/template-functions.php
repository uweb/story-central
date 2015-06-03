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
        'orderby' => 'modified',
        'meta_key' => 'promoted',
        'meta_value' => 'yes'
    );
    if (!empty($pillar)) {
        $args['pillar'] = $pillar->slug;
    }
    $query = new WP_Query($args);
    return $query->posts[0];
}

//"Abstract" section
//
function the_abstract_section( $post_id ) {
    echo get_the_abstract_section( $post_id );
}

function get_the_abstract_section( $post_id ) {
    $abstract = get_abstract_text($post_id);
    if (!empty($abstract)){
        $html = "
            <div class='widget uw-story-central'>
                <h3 class='widgettitle'>Abstract</h3>
                <div id='abstract-section'>" . $abstract . "</div>
            </div>";
        return story_section($html);
    }
    return '';
}

function get_abstract_text( $post_id ) {
    return get_post_meta($post_id, 'abstract', true);
}


//Link to source section
//
function the_source_link_section( $post_id ) {
    echo get_the_source_link_section( $post_id );
}

function get_the_source_link_section( $post_id ) {
    $src = get_post_meta($post_id, 'source', true);
    $html = "
    <div id='source-link'>
        <a class='button' href='" . $src . "'>Original article</a>
    </div>
    ";
    return story_section($html);
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
            <h3 class="widgettitle">Twitter</h3>
            <div class="twitter-widget copy">
              <div class="social-head">
                <div class="handle"><img src="'. get_stylesheet_directory_uri() .'/img/social.jpg">
                <span>University of Washington</span></div><p>'. $twitter->tweet .'</p>
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
            <h3 class="widgettitle">Facebook</h3>
            <div class="facebook-widget copy">
              <div class="social-head">
                <div class="handle"><img src="'. get_stylesheet_directory_uri() .'/img/social.jpg">
                <span>University of Washington</span></div>'. apply_filters('the_content', $facebook->post ) .'
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
            <h3 class="widgetitle">Related Links</h3>
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
            <h3 class="widgettitle">Contacts</h3>
            <p>'. $authors .'</p>
          </div>';

  return story_section( $html );

}

//
//Featured image section
//
function the_featured_image_section( $post_id ) {
    echo get_the_featured_image_section( $post_id );
}

function get_the_featured_image_section( $post_id )
{
    $post = get_post( $post_id );
    $url  = get_story_featured_image_url($post_id, false, array( 1200, 700 ));

    $html = "<div class=\"promoted-story-tile\">
                <img src=\"$url\" />
            </div>";

    return ! empty( $url ) ? story_section($html) : '';
}


function the_video_embed( $post_id )
{
  echo get_the_video_embed( $post_id );
}

function get_the_video_embed( $post_id )
{
  $video_url = (String) get_post_meta( $post_id, 'video', true );
  if ( ! $video_url ) return;
  $video = wp_oembed_get( $video_url );
  $html = '<div class="widget">
            <h3 class="widgettitle">Video</h3>
            <p> ' . $video . '</p>
          </div>';

  return story_section( $html );
}

function story_section( $html )
{
  return '<div class="story-section">' . $html . '</div>';
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

    $data = array( 'action' => 'get_image_assets', 'ids' => $media , 'name' => get_the_title( $post_id ) );

    $title = '<h3 class="widgettitle"><span>Image Assets</span></h3>';
    $downloadLink = '<a href="'.admin_url('admin-ajax.php').'?'. http_build_query($data).'" class="download-image-assets button">Download all</a>';

    $html = ! empty( $media ) ? '<div class="widget story-gallery">' . $title . do_shortcode('[gallery ids="'. $media .'" columns=7]') . $downloadLink . '</div>' : '';

    return $html;
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
function get_media_gallery_featured_image_url( $post_id, $backup=false, $size='thumbnail' ) {
    $media_arr = get_the_media_gallery_array( $post_id );
    $url = '';
    if ($backup) {
        $url = get_stylesheet_directory_uri() . '/img/social.jpg';                      //can set a default story image here
    }
    if ( !empty($media_arr) )
    {
        $image_id = $media_arr[0];
        $url = reset( wp_get_attachment_image_src( $image_id, $size ) );
    }
    return $url;
}

function get_story_featured_image_url( $post_id, $backup=false, $size ='thumbnail' ) {

    $url =  ( has_post_thumbnail( $post_id ) ) ?
              reset( wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) , $size ) ) :
              get_media_gallery_featured_image_url( $post_id, $backup, $size );

    return $url;
}

// gets cateogry posts
function get_the_pillar_posts() {
  $query = get_search_query();
  $pillars  = get_pillars();
  foreach ($pillars  as $pillar ) {
      if ( stripos($pillar->name, $query) !== false ) {
        $posts[] = get_stories_with_pillar( $pillar );
      }
  }

  return $posts  ? $posts : false;

}
