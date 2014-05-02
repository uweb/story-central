<?php

class UW_Story_Central_Install_Scripts extends UW_Install_Scripts
{

  function UW_Story_Central_Install_Scripts()
  {

    $this->SCRIPTS = array(

      'story' => array (
        'id'      => 'story',
        'url'     => get_bloginfo('stylesheet_directory') . '/js/story'. $this->dev_script() .'.js',
        'deps'    => array('jquery', 'backbone'),
        'version' => '1.0',
        'admin'   => false,
      ),

    );

    parent::UW_Install_Scripts();

  }

}

new UW_Story_Central_Install_Scripts;
