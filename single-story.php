<?php get_header(); ?>

<div id="primary">
	<div id="content" role="main" class="container">


		<div class="row">
			<div class="span8">

      <?php while (have_posts()) : the_post(); ?>

				<h1 class="entry-title"><?php the_title() ?></h1>
        <p class="author-info">By <?php the_author(); ?></p>


        <div class="block-row">
    			<?php the_content(); ?>
        </div>

				<?php the_twitter_section( get_the_ID() ); ?>

				<?php the_facebook_section( get_the_ID() ); ?>


      <?php endwhile; ?>

      </div>
		</div>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
