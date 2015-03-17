<?php get_header(); ?>


<?php while( have_posts() ) : the_post(); ?>

  <div id="story-bank-info">
    <h1><?php the_title(); ?></h1>
    <span class="udub-slant"><span></span></span>
    <?php the_content(); ?>
  </div>

<?php endwhile; ?>





    <div id="flex-bg">
      <div class="img-src orig"></div>
      <div id="blurred-background" class="img-src blrd"></div>
    </div>

    <div id="primary">
      <div id="content" role="main" class="container">

      <div class="row show-grid">

<div class="col-md-8 uw-content" role="main">
        <div>
            <?php $promoted = get_promoted_story(); ?>
            <div class='promoted-story-tile'>
                <div class='tile-background' style='background-image:url("<?php echo get_story_featured_image_url($promoted->ID, false, array(750,550) )?>");' ></div>
                <div class='tile-bottom'></div>
                <a href='<?php echo get_permalink($promoted->ID) ?>'><div class='tile-title-holder'>
                    <h2><?php echo $promoted->post_title ?></h2>
                    <p class='abstract'><?php echo get_abstract_text($promoted->ID) ?></p>
                </div></a>
            </div>


        <div id="feed">
           <?php foreach ( get_pillars() as $pillar ): ?>

             <h2><span><?php echo $pillar->name; ?></span></h2>

             <?php foreach( get_stories_with_pillar($pillar, 3) as $post ) : setup_postdata($post); ?>

                 <div class='story-tile'>
                     <div class='tile-background' style='background-image:url("<?php echo get_story_featured_image_url($post->ID, true, array( 150,150)) ?>");' >
                        <div class='tile-title-holder'>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                     </div>
                 </div>

             <?php endforeach; ?>

           <?php endforeach; ?>
        </div>

        </div>
</div>

<div class="col-md-4 uw-sidebar">
        <div id="secondary" class="right-bar" role="complementary">
          <div class="stripe-top"></div><div class="stripe-bottom"></div>
             <div id="sidebar">
              <?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
                        is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
               <a class="uw-btn btn-external btn-gold btn-sm" href="<?php echo admin_url('post-new.php?post_type=story'); ?>">Upload stories</a>
             </div><!-- #sidebar -->
        </div><!-- #secondary -->
</div>

      </div><!-- .show-grid -->
    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>
