<?php
class Story
{

  const POST_TYPE = 'story';
  const TAXONOMY  = 'pillar';

  function Story()
  {
    add_action( 'init', array( $this, 'init' ) );
    add_action( 'widgets_init', array( $this, 'deregister_widgets' ) );
    add_action( 'save_post', array( $this, 'save_story_cb'));
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
            'menu_name'         => 'Pillars',
    );

    register_post_type( self::POST_TYPE,
        array(
          'labels' => $labels,
          'public' => true,
          'show_ui' => true,
          'has_archive' => false,
          'menu_position' => 5,
          'show_in_nav_menus' => true,
          'register_meta_box_cb' => array( $this, 'add_meta_boxes' ),
          'supports' => array( 'title', 'editor', 'thumbnail' ),
          'yarpp_support' => true,
          'taxonomies' => array('post_tag'),
        )
    );

        register_taxonomy( self::TAXONOMY, self::POST_TYPE, array(
            'labels' => $pillar_labels,
            'show_ui' => true,
			'rewrite' => array( 'slug' => 'pillar' ),
			'hierarchical' => true,
		));

        register_taxonomy_for_object_type(self::TAXONOMY, self::POST_TYPE);

  }

  function deregister_widgets()
  {

      //todo: only unregister if on the story edit page?
      foreach ( $this->get_widgets() as $widget )
      {
        unregister_widget( $widget );
      }

  }

  function get_widgets()
  {
      return array(
        //default WP
        'WP_Widget_Pages',
        'WP_Widget_Calendar',
        'WP_Widget_Archives',
        'WP_Widget_Links',
        'WP_Widget_Meta',
        //'WP_Widget_Search',
        'WP_Widget_Text',
        'WP_Widget_Categories',
        'WP_Widget_Recent_Posts',
        'WP_Widget_Recent_Comments',
        'WP_Widget_RSS',
        'WP_Widget_Tag_Cloud',
        //'WP_Nav_Menu_Widget',
        //Custom UW
        //'UW_Widget_Single_Image',
        'UW_RSS_Widget',
        'UW_Widget_Recent_Posts',
        'UW_Widget_CommunityPhotos',
        'UW_Widget_Categories',
        'UW_Widget_Twitter',
        'UW_KEXP_KUOW_Widget',
        'UW_Showcase_Widget',
        'UW_Subpage_Menu',
        'UW_Nav_Menu_Widget',
        'UW_Calendar',
        'UW_Campus_Map',
        //'UW_Headline_Separator_Widget',
        'UW_Headline_Widget',
        'UW_Intro_Widget',
        'UW_YouTube_Playlist_Widget',
        'UW_Pride_Points',
        'Pagelet_Widget',
        //default PageBuilder
        'SiteOrigin_Panels_Widget_Animated_Image',
        'SiteOrigin_Panels_Widget_List',
        'SiteOrigin_Panels_Widget_Price_Box',
        'SiteOrigin_Panels_Widget_Testimonial',
        'SiteOrigin_Panels_Widgets_Gallery',
        'SiteOrigin_Panels_Widgets_PostContent',
        'SiteOrigin_Panels_Widgets_Image',
        'SiteOrigin_Panels_Widgets_PostLoop',
        'SiteOrigin_Panels_Widgets_EmbeddedVideo',
        'SiteOrigin_Panels_Widgets_Video',
        'SiteOrigin_Panels_Widget_Call_To_Action',

    );
  }





    function add_meta_boxes( $post ) {
        add_meta_box( 'abstract', 'Abstract', array( $this, 'abstract_cb' ), self::POST_TYPE );
        add_meta_box( 'source', 'Original Story Link', array( $this, 'source_cb' ), self::POST_TYPE );
        add_meta_box( 'gallery', 'Gallery', array( $this, 'gallery_cb' ), self::POST_TYPE );
        add_meta_box( 'video', 'Video', array( $this, 'video_cb' ), self::POST_TYPE );
        add_meta_box( 'twitter', 'Twitter', array( $this, 'twitter_cb' ), self::POST_TYPE );
        add_meta_box( 'facebook', 'Facebook', array( $this, 'facebook_cb' ), self::POST_TYPE );
        add_meta_box( 'links', 'Related Links', array( $this, 'links_cb' ), self::POST_TYPE );
        add_meta_box( 'orig_authors', 'Contacts', array( $this, 'original_authors_cb' ), self::POST_TYPE );
        add_meta_box( 'promoted', 'Promoted to top of page?', array( $this, 'promoted_cb' ), self::POST_TYPE, 'side' );
    }

    function abstract_cb( $post ){
        $abstract = (String) get_post_meta($post->ID, 'abstract', true);
        wp_editor($abstract, 'story-abstract', array('textarea_name' => 'abstract', 'media_buttons' => false, 'textarea_rows' => 3, 'teeny' => true));
    }

    function gallery_cb( $post ) {
      $gallery = (String) get_post_meta( $post->ID, 'gallery', true ); $text = !$gallery ? 'Add a' : 'Edit'; ?>

      <div class="uploader">
        <input type="text" name="gallery" id="gallery-ids" class="hidden" value="<?php echo $gallery; ?>"/>
        <a class="button" name="gallery" id="story-gallery" ><?php echo $text ?> gallery</a>
        <p id="gallery-message">
          <?php if( $gallery ): ?>
            <?php echo sizeof( explode(',', $gallery ) ); ?> image(s) in the gallery. Click '<?php echo $text ?> gallery' to view them.
          <?php endif; ?>
        </p>
      </div>

      <script type="text/javascript">
      var media;

      (function($) {

        media = media || {}
        media = {
          button : '#story-gallery',
          detail : '#gallery-ids',
          message : '#gallery-message',
          init : function() {
            $(this.button).on( 'click', $.proxy( this.open, this ) )
          },
          open : function( e ) {

            if ( wp.media.frames.storycentral ) {
              wp.media.frames.storycentral.setState('gallery-edit')
              wp.media.frames.storycentral.open()
              //wp.media.gallery.edit('[gallery ids="'+ $(this.detail).val() +'"]')
              return;
            }

            this._frame = wp.media.frames.storycentral = wp.media({
              frame: 'post',
              state : $(this.detail).val().length > 0 ? 'gallery-edit' : 'gallery',
              multiple: true,
              title: 'Create a gallery',
            })

            // this._frame.on('activate', this.hideSidebar)
            this._frame.on('open', $.proxy(this.activateLibrary, this ) )
            this._frame.on('update', $.proxy( this.handleMedia, this ) )
            this._frame.on('close', $.proxy(this.close , this ) )
            this._frame.open()
          },

          activateLibrary : function() {

            var selection = this._frame.state().get('library')
              , value     = $(this.detail).val()
              , ids = ! value ? false : value.split(',')


            if ( ids ) {
              $.each( ids, function( index, id ) {
                wp.media.attachment(id).fetch({
                  success: function( model, response ) {
                    selection.add( model )
                  }
                })
              });
            }

          },

          handleMedia : function() {
            var attachments = this._frame.state().get('library').toJSON()
            $(this.detail).val( _.pluck( attachments, 'id' ).join(',') )
            $(this.message).html( attachments.length + " image(s) in gallery. Click 'Edit gallery' to view them.")
            // _.each( attachments, $.proxy( this.appendImagePreview, this) )
          },

          // appendImagePreview : function( attachment ) {
          //   var ratio = attachment.width / attachment.height;
          //   $(this.detail).after('<img src="'+ attachment.url +'" width="40" height="'+ 40 * ratio +'" />')
          // },

         close : function() {
           $(this.button).html('Edit gallery')
         },

        //  hideSidebar : function() {
        //    $('media-modal').addClass( 'no-sidebar' )
        //  }

      }

      $(document).ready(function(){ media.init() })

    })(jQuery)



      </script>
      <?php
    }

    function twitter_cb( $post ) {
        $twitter = (object) get_post_meta( $post->ID, 'twitter', true ); ?>


        <p>
          <label class="" for="twitter[name]">Username: </label>
          <input name="twitter[name]" type="text" id="twitter-name" value="<?php echo $twitter->name ?>"/>
        </p>

        <label class="" for="twitter[tweet]">Tweet: </label>

        <?php wp_editor( $twitter->tweet, 'twitter-tweet', array('textarea_name'=> "twitter[tweet]", 'media_buttons'=> false, 'textarea_rows' => 3, 'teeny' => true ) ); ?>

        <p id="twitter-character-count"><?php echo 140 - strlen($twitter->tweet) ?> characters left!</p>

        <script type="text/javascript">

          jQuery(document).ready(function( $ ) {

            var editor   = tinyMCEPreInit.mceInit['twitter-tweet']
                , $count = $('#twitter-character-count')
                , limit  = 140

            editor.setup = function( ed ) {

              ed.onKeyUp.add(function(ed, e) {
                var text = ed.getContent({format : 'text'})
                  , count = Math.max( 0, limit - text.length )
                  , characters = count === 1 ? 'character' : 'characters'
                  , message = count + ' ' + characters + ' left!'

                $count.html(message)

              })

            }


          })

        </script>
        <?php
    }

    function facebook_cb( $post ) {
        $facebook = (object) get_post_meta($post->ID, 'facebook', true); ?>

        <p>
          <label class="" for="facebook[name]">Username: </label><br/>
          <input name="facebook[name]" type="text" id="facebook-name" value="<?php echo $facebook->name ?>"/>
        </p>

        <label class="" for="facebook[post]">Post: </label>

        <?php wp_editor( $facebook->post, 'facebook-post', array('textarea_name'=> "facebook[post]", 'textarea_rows' => 5, 'teeny' => true ) );
    }

    function links_cb( $post ) {
        $links = (String) get_post_meta($post->ID, 'links', true);
        wp_editor($links, 'related-links', array('textarea_name' => 'links', 'media_buttons'=> false, 'textarea_rows' => 3, 'teeny' => true ) );
    }

    function original_authors_cb( $post ) {
        $authors = (String) get_post_meta( $post->ID, 'authors', true ); ?>

        <label  for="authors">Author(s) to contact for more information: </label>

        <?php wp_editor( $authors, 'original-authors', array('textarea_name' => 'authors', 'media_buttons'=> false, 'textarea_rows' => 3, 'teeny' => true ));
    }

    function promoted_cb( $post ) {
        $promoted_str = (String) get_post_meta( $post->ID, 'promoted', true );
        $promoted = false;
        if ($promoted_str == 'yes') {
            $promoted = true;
        }?>
        <select name='promoted' id='promoted-to-top'>
            <option value='no'<?php if (!$promoted) { ?> selected='selected'<?php } ?>>No</option>
            <option value='yes'<?php if ($promoted) { ?> selected='selected'<?php } ?>>Yes</option>
        </select>
        <?php
    }

    function source_cb( $post ) {
        $source = (String) get_post_meta($post->ID, 'source', true);
        ?>
        <label for='source'>URL</label>
        <input size="100%" type='text' name='source' value='<?= $source ?>' />
        <?php
    }

    function video_cb( $post ) {
      $video_url = (String) get_post_meta( $post->ID, 'video', true );
      ?>

      <label for="video">Video URL: </label>
      <input name="video" type="text" size="100%" value="<?php echo $video_url; ?>" />
      <p><a target="_blank" title="Embedable urls" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">List of compatible URLs</a></p>
      <?php
    }

    function save_story_cb( $post_id ) {

        // todo: validation
        $abstract  = $_POST['abstract'];
        $twitter  = $_POST['twitter'];
        $facebook = $_POST['facebook'];
        $links    = $_POST['links'];
        $authors  = $_POST['authors'];
        $gallery  = $_POST['gallery'];
        $source   = $_POST['source'];
        $video    = $_POST['video'];
        $promoted = $_POST['promoted'];

        update_post_meta( $post_id, 'abstract', $abstract );
        update_post_meta( $post_id, 'twitter', $twitter );
        update_post_meta( $post_id, 'facebook', $facebook );
        update_post_meta( $post_id, 'links', $links);
        update_post_meta( $post_id, 'authors', $authors);
        update_post_meta( $post_id, 'gallery', $gallery);
        update_post_meta( $post_id, 'source', $source);
        update_post_meta( $post_id, 'video', $video );
        update_post_meta( $post_id, 'promoted', $promoted);
    }
}

new Story;
