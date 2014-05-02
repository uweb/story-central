<?php
/**
 * UW Story Gallery
 * - Shows all the assets relating to a certain story
 * - Provides an ajax url for zipping up and downloading all the image files
 */

class UW_Story_Gallery
{

  function UW_Story_Gallery()
  {
    add_filter( 'post_gallery', array( $this, 'uw_gallery_template' ), 11, 2 );
    add_action('wp_ajax_get_image_assets', array( $this, 'image_assets' ) );
  }

  function uw_gallery_template( $output, $attr )
  {
    global $post;
    $data = array( 'action' => 'get_image_assets', 'ids' => $attr['ids'] , 'name' => $post->post_name );

    //TODO : change hardcoded html to the dynamic
    $title = '<h3 class="widget-title"><span>Image Assets</span></h3>';
    return $title . $output. '<a href="'.admin_url('admin-ajax.php').'?'. http_build_query($data).'" class="download-image-assets button pull-right">Download all</a>';
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
        echo $image . "\n";
        $zip->addFile( $image );
      } else {
        die("File $filepath doesnt exit");
      }

    }

  $zip->close();

   header('Content-Type: application/zip');
   header('Content-disposition: attachment; filename=' . $name );
   header('Content-Length: ' . filesize($path) );
   readfile( $path );
   wp_die();

  }

}

new UW_Story_Gallery;