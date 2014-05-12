<?php get_header(); ?>


<?php

  $args = array( 'category_name' => 'Blurb', 'numberposts' => '1' );
  $postslist = get_posts( $args );
  foreach ($postslist as $post) :  setup_postdata($post); ?> 
  
  <div id="story-bank-info">
    <h1><?php the_title(); ?></h1><?php the_content(); ?>
    <a class="button" href="<?php echo admin_url('post-new.php?post_type=story'); ?>">Upload stories</a>
  </div>

<?php endforeach; ?>




<?php while( have_posts() ) : the_post(); ?>

    <div id="flex-bg">
      <div class="img-src orig"></div>
      <div id="blurred-background" class="img-src blrd"></div>
    </div>

    <div id="primary">
      <div id="content" role="main" class="container">

      <div class="row show-grid">
        <div id="main" class="span8">
            <?php $promoted = get_promoted_story(); ?>
            <div class='promoted-story-tile'>
                <div class='tile-background' style='background-image:url("<?= get_story_featured_image_url($promoted->ID )?>");' ></div>
                <div class='tile-bottom'></div>
                <a href='<?= get_permalink($promoted->ID) ?>'><div class='tile-title-holder'>
                    <h2><?= $promoted->post_title ?></h2>
                    <p class='excerpt'><?= $promoted->post_excerpt ?></p>
                </div></a>
            </div>
          

        <div id="feed">
           <?php foreach ( get_pillars() as $pillar ): ?>

             <h2><span><?php echo $pillar->name; ?></span></h2>

             <?php $stories = get_stories_with_pillar($pillar, 4); ?>

             <?php foreach( get_stories_with_pillar($pillar) as $post ) : setup_postdata($post); ?>
                 
                 <?php
                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                    $thumb_url = $thumb_url_array[0];                    
                 ?>

                 <div class='story-tile'>
                     <div class='tile-background' style='background-image:url(<?php echo $thumb_url; ?>);' >
                        <div class='tile-title-holder'>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>                      
                     </div>
                 </div>

             <?php endforeach; ?>

           <?php endforeach; ?>
        </div>

        </div>
 
        <div id="secondary" class="span4 right-bar" role="complementary">
          <div class="stripe-top"></div><div class="stripe-bottom"></div>
             <div id="sidebar">
              <?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
                        is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
             </div><!-- #sidebar -->
        </div><!-- #secondary -->


      </div><!-- .show-grid -->
    </div><!-- #content -->
  </div><!-- #primary -->

  <?php endwhile; ?>


<?php get_footer(); ?>
