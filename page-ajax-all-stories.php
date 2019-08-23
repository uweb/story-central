<div id="grid-sizer" class="grid-sizer"></div>
<?php
  $args = array(
    'posts_per_page'  => 100,
    'orderby'         => 'post_date',
    'post_type'       => 'story',
    'post_status'     => 'publish'
  );
  $posts = get_posts($args);
  foreach( $posts as $post ) : setup_postdata($post);
    $tags = "";
    $slugs = wp_get_post_tags($post->ID, array('fields' => 'slugs'));
    foreach($slugs as $slug) : $tags = $tags . $slug . " "; endforeach;
    $pillars = wp_get_post_terms($post->ID, 'pillar', array('fields' => 'slugs'));
    foreach($pillars as $pillar) : $tags = $tags . $pillar . " "; endforeach; ?>

     <div class="boundless-tile grid-item element-item <?php echo $tags; ?>" >
         <div class='boundless-image' style='background-image:url("<?php echo get_story_featured_image_url($post->ID, false, array(350,350)) ?>");' ></div>
            <div class="boundless-text">
                <h3 class="searchtag"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h3>
                <p class="searchtag"><?php echo get_abstract_text($post->ID); ?></p>
                <div class="searchbody" style="display:none"><?php echo the_content(); ?></div>
                <a class="more" href='<?php the_permalink(); ?>'>More</a>
         </div>
     </div>

<?php endforeach; ?>

