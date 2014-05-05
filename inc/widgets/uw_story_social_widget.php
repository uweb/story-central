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
        $type = $instance['type'];
        $text = $instance['text'];
        ?>
        <div class='widget uw_story_social'>
            <h3 class='widget-title'><?= $type ?></h3>
            <div class='<?= strtolower($type) ?>-widget social-widget'>
                <div>
                    <img src='<?= get_stylesheet_directory_uri() ?>/img/social.jpg'>
                    <span>University of Washington</span>
                </div>
                <p><?= $text ?></p>
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
        ?>
        <label for='social-type'>Social Network</label>
        <select id='social-type' name='<?= $this->get_field_name('type') ?>'><?php
        foreach ($socials as $social) {
            ?>
            <option value='<?= $social ?>' <?php if ($type == $social){ ?> selected <?php } ?>><?= $social ?></option>
        <?php } ?>
        </select>
        <input type='text' name='<?= $this->get_field_name('text') ?>' value='<?= $text ?>' />
        <?php
    }
}
?>
