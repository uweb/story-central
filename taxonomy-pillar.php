<?php get_header(); ?>

    <div id="story-bank-info">
      <a class="button" href="<?php echo admin_url('post-new.php?post_type=story'); ?>">Upload stories</a>
    </div>

    <div id="flex-bg">
      <div class="img-src orig"></div>
      <div id="blurred-background" class="img-src blrd"></div>
    </div>

    <div id="primary">
      <div id="content" role="main" class="container">

      <div class="row show-grid">
        <div id="main" class="span8">
            
            <?php $pillar = get_term_by('slug', $pillar, 'pillar');?>

            <h2><?= $pillar->name ?></h2>

            <?php $stories = get_stories_with_pillar($pillar, 40); ?>

            <?php foreach( get_stories_with_pillar($pillar) as $post ) : setup_postdata($post); ?>
                
                <div class='story-tile'>
                    <div class='tile-background' style='background-image:url("<?= get_media_gallery_featured_image_url($post->ID) ?>");' ></div>
                    <div class='tile-bottom'></div>
                    <div class='tile-title-holder'>
                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                    </div>
                </div>

            <?php endforeach; ?>

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

<?php get_footer(); ?>
