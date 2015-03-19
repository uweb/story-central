<?php
$pillar = get_term_by('slug', $pillar, 'pillar');
$promoted = get_promoted_story($pillar);

get_header();
?>

  <div id="story-bank-info">
    <h1><?php echo $pillar->name ?></h1>
    <span class="udub-slant"><span></span></span>
  </div>

    <div id="flex-bg">
      <div class="img-src orig"></div>
      <div id="blurred-background" class="img-src blrd"></div>
    </div>

    <div id="primary">
      <div id="content" role="main" class="container">

      <div class="row show-grid">
        <div id="main" class="col-md-8 uw-content">
            <?php if (!empty($promoted)): ?>
            <div class='promoted-story-tile'>
                <div class='tile-background' style='background-image:url("<?php echo get_story_featured_image_url($promoted->ID, true, array(750,550) )?>");' ></div>
                <div class='tile-bottom'></div>
                <a href='<?php echo get_permalink($promoted->ID) ?>'><div class='tile-title-holder'>
                    <h2><?php echo $promoted->post_title ?></h2>
                    <p class='abstract'><?php echo get_abstract_text($promoted->ID) ?></p>
                </div></a>
            </div>
            <div class='spacer'></div>
            <?php endif ?>

            <?php foreach( get_stories_with_pillar($pillar) as $post ) : setup_postdata($post); ?>

                <div class='story-tile'>
                    <div class='tile-background' style='background-image:url("<?php echo get_story_featured_image_url($post->ID, true) ?>");' ></div>
                    <div class='tile-bottom'></div>
                    <div class='tile-title-holder'>
                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <div id="secondary" class="col-md-4 uw-sidebar" role="complementary">
          <div class="stripe-top"></div><div class="stripe-bottom"></div>
             <div id="sidebar">
              <?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
                        is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
               <a class="uw-btn btn-external btn-gold btn-sm" href="https://catalyst.uw.edu/webq/survey/jswen/259668">Pitch a story</a>
             </div><!-- #sidebar -->
        </div><!-- #secondary -->


      </div><!-- .show-grid -->
    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>
