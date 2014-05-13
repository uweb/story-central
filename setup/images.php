<?php
$sizes = get_intermediate_image_sizes();
foreach ( $sizes as $size ) {   // just nuke all sizes
    unset($size);
}
