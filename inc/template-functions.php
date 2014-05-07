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
  $html = '<div class="widget uw_story_social">
            <h3 class="widget-title">Twitter</h3>
            <div class="twitter-widget">
              <div class="social-head">
                <img src="'. get_stylesheet_directory_uri() .'/img/social.jpg">
                <span>University of Washington</span><p>'. $twitter->tweet .'</p>
              </div>
           </div>';

  echo $html;
}
