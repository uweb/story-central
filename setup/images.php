<?php

/**
 * Installs the custom image sizes
 */

class Story_Images extends UW_Images
{

  // If 'show' is true it will appear in the image dropdown menu
  public $IMAGE_SIZES = array(
  );

  function UW_Images()
  {

    add_action( 'after_setup_theme', array( $this, 'add_uw_image_sizes' ) );
    add_filter( 'image_size_names_choose', array( $this, 'show_image_sizes') );
  }

  function add_uw_image_sizes()
  {
    add_filter( 'image_size_names_choose', array( $this, 'show_image_sizes') );
  }

  function show_image_sizes( $defaultSizes )
  {
    $imagesToShow = array_filter( $this->IMAGE_SIZES, function($image) { 
      return $image['show'];
    });

    foreach ($imagesToShow as $id=>$image) 
    {
      $imagesToShow[$id] = $image['name'];
    }


    return (array_merge( $imagesToShow , $defaultSizes ));

  }

  parent::UW_Images();
}

new Story_Images;
