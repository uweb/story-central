<?php
/**
 * UW Story Gallery
 * - Provides an ajax url for zipping up and downloading all the image files
 */

class UW_Story_Gallery extends WP_Widget
{

  function UW_Story_Gallery()
  {
    add_action( 'wp_ajax_nopriv_get_image_assets', array( $this, 'image_assets' ) );
    add_action( 'wp_ajax_get_image_assets', array( $this, 'image_assets' ) );
  }

  function image_assets() {

    // TODO: check if ziparchive is installed cms/cmsdev
    $zip = new ZipArchive();

    $ids = explode( ',' , $_GET['ids'] );
    $name = $_GET['name'] . '.zip';
    $path = get_temp_dir() . $name;

    if ($zip->open( $path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE ) {
      die(json_encode(array('error'=>'Could not retrieve files.')));
    }

    foreach ( $ids as $id )
    {

      $image = get_attached_file($id);

      if ( file_exists($image) ) {
        $zip->addFile( $image, basename($image));
      } else {
        // die("File $filepath doesnt exit");
      }

    }

  $zip->close();

   header('Content-Type: application/zip');
   header('Content-disposition: attachment; filename=' . $name );
   header('Content-Length: ' . filesize($path) );

  //TODO: alternate method to make zip file work?
    ob_clean();
    flush();
   readfile( $path );

   wp_die();

  }

}

new UW_Story_Gallery;
