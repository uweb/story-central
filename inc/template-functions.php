<?php

function get_pillars() {
  return get_terms('pillar', 'orderby=none&hide_empty');
}

function get_stories_with_pillar( $pillar ) {
  return get_posts(array(
    'post_type' => 'story',
    'tax_query' => array(
        array(
        'taxonomy' => 'pillar',
        'field' => 'term_id',
        'terms' => $pillar )
    ))
);

}
