<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

    <div <?php uw_content_class(); ?> role='main'>

      <?php uw_site_title(); ?>

      <?php get_template_part('menu', 'mobile'); ?>

      <?php get_template_part( 'breadcrumbs' ); ?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">


        <?php

          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              get_template_part( 'content', 'archive' );
            endwhile;
          elseif ( $posts = get_the_pillar_posts() ) :
            foreach ($posts as $post ) : setup_postdata( $post );
          ?>
            <?php the_date('F j, Y', '<p class="date">', '</p>'); ?>
            <h1>
              <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
            </h1>
            <?php
            if (get_option('show_byline_on_posts')) :
            ?>
            <div class="author-info">
                <?php the_author(); ?>
                <p class="author-desc"> <small><?php the_author_meta(); ?></small></p>
            </div>
            <?php
            endif;
            ?>
              <?php the_excerpt(); ?>

          <?php
            endforeach;
          else :
            echo '<h3 class=\'no-results\'>Sorry, no results matched your criteria.</h3>';
          endif;
        ?>

        <?php posts_nav_link(' '); ?>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>
