<?php get_header(); ?>

<div id="primary">
	<div id="content" role="main" class="container">


		<div class="row show-grid">

<?php foreach ( get_pillars() as $pillar ): ?>

  <h2><?php echo $pillar->name; ?></h2>

  <?php $stories = get_stories_with_pillar($pillar); ?>

  <?php foreach( get_stories_with_pillar($pillar) as $post ) : setup_postdata($post); ?>

    <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a>

  <?php endforeach; ?>

<?php endforeach; ?>

		 </div>
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
