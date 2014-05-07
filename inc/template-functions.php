<?php

function get_pillars()
{
  return get_terms('pillar', 'orderby=none&hide_empty');
}

function get_stories_with_pillar( $pillar )
{
  return get_posts(array(
    'post_type' => 'story',
    'tax_query' => array(
        array(
        'taxonomy' => 'pillar',
        'field' => 'term_id',
        'terms' => $pillar )
  )) );
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

  echo $html;
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
                <span>University of Washington</span><p>'. $facebook->post .'</p>
              </div>
           </div>
          </div>';

  echo $html;


}
