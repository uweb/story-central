<?php
class UW_Story_Social_Widget extends WP_Widget {

    public function UW_Story_Social_Widget() {
        parent::__construct(
            'uw_story_social_widget',
            'UW Story Social Widget',
           array(
                'classname' => 'uw_story_social_widget',
                'description' => __("Social widget for Story Central")
            )
        );
    }

    public function widget($args, $instance){
        global $post;
        $postID = $post->ID;
        $type = $instance['type'];
        $text = $instance['text'];
        ?>
        <div class='widget uw-story-social'>
            <h3 class='widget-title'><?php echo $type ?></h3>
            <div class='<?php echo strtolower($type) ?>-widget'>
                <div class='social-head'>
                    <img src='<?php echo get_stylesheet_directory_uri() ?>/img/social.jpg'>
                    <span>University of Washington</span>
                </div>
                <p><?php echo $text ?></p>
            </div>
        </div>
        <?php
    }

    function update($new_instance, $old_instance){
        $instance = array();
        $instance['type'] = $new_instance['type'];
        $instance['text'] = $new_instance['text'];
        return $instance;
    }

    public function form($instance){
        $type = $instance['type'];
        $text = $instance['text'];
        $socials = array('Facebook', 'Twitter');
        $rand = rand(0, 9999);
        ?>
        <label for='social-type'>Social Network</label>
        <select id='social-type' name='<?php echo $this->get_field_name('type') ?>'><?php
        foreach ($socials as $social) {
            ?>
            <option class='<?php echo $social ?>' value='<?php echo $social ?>' <?php if ($type == $social){ ?> selected <?php } ?>><?php echo $social ?></option>
        <?php } ?>
        </select>
        <?php
        wp_editor($text, $this->get_field_id('text_' . $rand), array('textarea_rows' => 6, 'textarea_name' => $this->get_field_name('text')));
        ?>
        <script>
            jQuery(document).ready(
                function($) {
                    $( '.widget-control-save' ).click(
                        function() {
                            var saveID = $( this ).attr( 'id' );
                            var ID = saveID.replace( /-savewidget/, '' );
                            var textTab = ID + '-text_<?php echo $rand ?>-html';
                            $( '#'+textTab ).trigger( 'click' );

                        }
                    );
                }
            );
        </script>
        <?php
    }
}
?>
