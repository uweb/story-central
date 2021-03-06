<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

	<div id="content" role="main" class="container uw-body">


		<div class="row">
			<div class="col-md-8 uw-content">

                    <?php get_template_part( 'breadcrumbs' ); ?>

      <?php while (have_posts()) : the_post(); ?>

				<h1 class="entry-title"><?php the_title() ?></h1>
				
				<?php the_story_pillar( get_the_ID() ); ?>

                <?php the_featured_image_section( get_the_ID() ); ?>

                <?php the_abstract_section( get_the_ID() ); ?>

        <div class="block-row">
    			<?php the_content(); ?>
        </div>

        		<?php the_source_link_section( get_the_ID() ); ?>

				<?php the_media_gallery_section( get_the_ID() ); ?>

				<?php the_video_embed( get_the_ID() ); ?>

				<?php the_twitter_section( get_the_ID() ); ?>

				<?php the_facebook_section( get_the_ID() ); ?>

				<?php the_external_links_section( get_the_ID() ); ?>

				<?php the_original_authors_section( get_the_ID() ); ?>

				<?php the_story_tags( get_the_ID() ); ?>

      <?php endwhile; ?>

			<?php comments_template(); ?>

      </div>

			<div id="secondary" class="col-md-4 uw-sidebar" role="complementary">
				<div class="stripe-top"></div><div class="stripe-bottom"></div>
					<div id="sidebar">
						<?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
											is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
					</div><!-- #sidebar -->
			</div><!-- #secondary -->

		</div>

	</div><!-- #content -->

<?php get_footer(); ?>
