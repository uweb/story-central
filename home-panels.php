<?php get_header(); ?>

		<div id="story-bank-info">
			<h1>Story Central</h1>
			<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia </p>
			<a class="button" href="#">Upload stories</a>
		</div>

		<div id="flex-bg">
			<div class="img-src orig"></div>
    		<div class="img-src blrd"></div>
		</div>

		<div id="primary">
			<div id="content" role="main" class="container">
						
			<div class="row show-grid">
				<div id="main" class="span8">
					
					<?php echo siteorigin_panels_render('home'); ?>
		
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

