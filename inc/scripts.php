<?php

class Social_Install_Scripts extends UW_Install_Scripts
{

  function Social_Install_Scripts() 
  {

    $this->SCRIPTS = array( 

      'social' => array ( 
        'id'      => 'social',
        'url'     => get_bloginfo('stylesheet_directory') . '/js/social'. $this->dev_script() .'.js',
        'deps'    => array('jquery', 'backbone'),
        'version' => '1.0',
        'admin'   => false,
      ),

    );
    
    parent::UW_Install_Scripts();

  }

}

new Social_Install_Scripts;
