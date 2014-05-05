<?php
class Story
{

  const POST_TYPE = 'story';
  const TAXONOMY  = 'pillar';

  function Story()
  {
    add_action( 'init', array( $this, 'init' ) );
  }

  function init()
  {


    $labels = array(
      'name' => 'Stories',
      'singular_name' => 'Story',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Story',
      'edit_item' => 'Edit Story',
      'new_item' => 'New Story',
      'all_items' => 'All Stories',
      'view_item' => 'View Story',
      'search_items' => 'Search Stories',
      'not_found' =>  'No Stories found',
      'not_found_in_trash' => 'No Stories found in Trash',
      'menu_name' => 'Stories',

    );

    $pillar_labels = array(
      'name'              => 'Pillars',
  		'singular_name'     => 'Pillar',
  		'search_items'      => 'Search Pillars',
  		'all_items'         => 'All Pillars',
  		'parent_item'       => 'Parent Pillar',
  		'parent_item_colon' => 'Parent Pillar:',
  		'edit_item'         => 'Edit Pillar',
  		'update_item'       => 'Update Pillar',
  		'add_new_item'      => 'Add New Pillar',
  		'new_item_name'     => 'New Pillar Name',
		  'menu_name'         => 'Pillar',
    );

    register_post_type( self::POST_TYPE,
        array(
          'labels' => $labels,
          'public' => true,
          'show_ui' => true,
          'has_archive' => false,
          'menu_position' => 5,
          'show_in_nav_menus' => true,
          //'register_meta_box_cb' => array( $this, 'add_meta_boxes' )
          //'supports' => array( 'title', 'editor', 'category' )
        )
    );

    register_taxonomy( self::TAXONOMY, self::POST_TYPE, array(
      'labels' => $pillar_labels,
      'show_ui' => false,
			'rewrite' => array( 'slug' => 'pillar' ),
			'hierarchical' => true,
		));

  }


  // NOT BEING USED AT THE MOMENT FROM HERE DOWN

  function add_meta_boxes( $post )
  {
    add_meta_box( 'gallery',    'Gallery',      array( $this, 'gallery_cb' ),     self::POST_TYPE );
    add_meta_box( 'twitter',    'Twitter',     array( $this, 'twitter_cb' ),     self::POST_TYPE );
    add_meta_box( 'facebook', 'Facebook', array( $this, 'facebook_cb' ), self::POST_TYPE );
    add_meta_box( 'links',        'Links',       array( $this, 'links_cb' ),        self::POST_TYPE );
  }

  function gallery_cb() {
    echo 'Add gallery button here';
  }

  function twitter_cb() {
?>

      <label class="" for="twitter[name]">Username: </label><br/>
      <input name="twitter[name]" type="text" id="twitter-name" value=""/> <br/><br/>
      <label class="" for="twitter[tweet]">Tweet: </label> <textarea name="twitter[tweet]" id="twitter-tweet" style="resize: none; margin: 0; height: 4em; width: 98%;"></textarea>
      <p id="twitter-character-count">140 characters left!</p>
      <script>
        jQuery(document).ready(function( $ ) {
          var $tweet = $('#twitter-tweet')
              , $count = $('#twitter-character-count')
              , limit = 140

          $tweet.on( 'keyup', function( e ) { var len = $(this).val().length, count = limit - len, characters = count === 1 ? 'character' : 'characters', message = count + ' ' + characters + ' left!'; $count.html(message);})
        })
      </script>

<?php
  }

  function facebook_cb() {
    echo 'facebook callback';
  }

  function links_cb() {
    echo 'links';
  }


}

new Story;
