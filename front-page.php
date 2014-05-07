<?php get_header(); ?>

<?php while( have_posts() ) : the_post(); ?>

    <div id="story-bank-info">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
      <a class="button" href="<?php echo admin_url('post-new.php?post_type=story'); ?>">Add a story</a>
    </div>

    <div id="flex-bg">
      <div class="img-src orig"></div>
      <div id="blurred-background" class="img-src blrd"></div>
    </div>

    <div id="primary">
      <div id="content" role="main" class="container">

      <div class="row show-grid">
        <div id="main" class="span8">
          
          <?php foreach ( get_pillars() as $pillar ): ?>

            <h2><?php echo $pillar->name; ?></h2>

            <?php $stories = get_stories_with_pillar($pillar); ?>

            <?php foreach( get_stories_with_pillar($pillar) as $post ) : setup_postdata($post); ?>

              <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a>

            <?php endforeach; ?>

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

  <?php endwhile; ?>


<?php get_footer(); ?>
