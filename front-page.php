
<?php get_header(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.0/isotope.pkgd.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/packery/1.4.1/packery.pkgd.js"></script>
<script>
  $( document ).ready( function() {

  // quick search regex
  var qsRegex;
  var buttonFilter;
  var filters = {};

  var filterFunction = function() {
      var $this = $(this);
      var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
      var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
      return searchResult && buttonResult;
  }


  //init Isotope
  var $container = $('.isotope').isotope({
    itemSelector: '.element-item',
    masonry: {
      gutter: 10
    }
  });

  $('.filters-select').on( 'change', function() {
    var $this = $(this);
    var filterGroup = $this.attr('data-filter-group');
    filters[ filterGroup ] = this.value;
    buttonFilter = concatValues( filters );
    $container.isotope({ filter : filterFunction });
  });

  // use value of search field to filter
  $('#storycentral-search').on( 'keyup', function() {
    var $this = $(this);
    var search = $('#storycentral-search').val();
    qsRegex = new RegExp( search, 'gi' );
    $container.isotope({ filter : filterFunction });
  });



  function concatValues( obj ) {
  var value = '';
  for ( var prop in obj ) {
    if(obj[prop] != "*"){
      value += obj[ prop ];
    }
  }
  return value;
  }
});

</script>
<!-- uses post to fill in archive page's title/tag line -->
<?php while( have_posts() ) : the_post(); ?>

  <div id="story-bank-info">
    <h1 class="uw-site-title"><?php the_title(); ?></h1>
    <span class="udub-slant"><span></span></span>
    <?php the_content(); ?>
  </div>

<?php endwhile; ?>

<div id="flex-bg">
  <div class="img-src orig"></div>
  <div id="blurred-background" class="img-src blrd"></div>
</div>

<div id="primary" class="tan-bg">

  <div class="container uw-body boundless-archive">
  <div class="row">

  <div class="col-md-12 uw-content" role="main">
  <div id='main_content' class="uw-body-copy">
        <!-- Story Cental - Spotlight Story -->
          <!--  <?php $promoted //= get_promoted_story(); ?>
            <div class='promoted-story-tile'>
                <div class='tile-background' style='background-image:url("<?php //echo get_story_featured_image_url($promoted->ID, false, array(750,550) )?>");' ></div>
                <div class='tile-bottom'></div>
                <a href='<?php //echo get_permalink($promoted->ID) ?>'><div class='tile-title-holder'>
                    <h2><?php //echo $promoted->post_title ?></h2>
                    <p class='abstract'><?php //echo get_abstract_text($promoted->ID) ?></p>
                </div></a>
            </div> -->
 <div id="filters" class="row">
 <div class="dropdowns col-md-6">

  <div class="row">

    <label for="pillars">Pillar:</label>
    <select id="pillar" name="pillars" class="filters-select button-group" data-filter-group="pillar">
      <option value="*">Show all</option>
      <?php foreach(get_pillars() as $pillar) : ?>
        <option value=".<?php echo $pillar->slug; ?>"><?php echo $pillar->name ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="row">

    <label for="tags"> Tag: </label>
    <select id="tags" name="tags" class="filters-select button-group" data-filter-group="tag">
      <option value="*">Show all</option>
      <?php foreach(get_tags() as $tag) : ?>
        <option value=".<?php echo $tag->slug; ?>"><?php echo $tag->name ?></option>
      <?php endforeach; ?>
    </select>

  </div>

 </div>

    <div class="col-md-6">
    <div class="row">
      <label class="screen-reader-text" for="storycentral-search" style="visibility:hidden;">Search for:</label>
      <input type="text" value name="storycentral-search" id="storycentral-search" class="searchbar quicksearch" placeholder="Search for:" />
      <input type="submit" class="filters-search" id="storycentral-searchsubmit" data-filter-group="search" value="Search">
    </div>
    </div>
  </div>

      <div id="archive_section">
      <div class="grid js-isotope isotope">
           <?php
           $args = array(
            'posts_per_page'  => -1,
            'orderby'         => 'post_date',
            'post_type'       => 'story',
            'post_status'     => 'publish'
          );
          $posts = get_posts($args);
          foreach( $posts as $post ) : setup_postdata($post);
          $tags = "";
          $slugs = wp_get_post_tags($post->ID, array('fields' => 'slugs'));
          foreach($slugs as $slug) : $tags = $tags . $slug . " "; endforeach;
          $pillars = wp_get_post_terms($post->ID, 'pillar', array('fields' => 'slugs'));
          foreach($pillars as $pillar) : $tags = $tags . $pillar . " "; endforeach; ?>

               <div class="grid-sizer"></div>
               <div class="boundless-tile grid-item element-item <?php echo $tags; ?>" >
                   <div class='boundless-image' style='background-image:url("<?php echo get_story_featured_image_url($post->ID) ?>");' ></div>
                      <div class="boundless-text">
                          <h3 class="searchtag"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h3>
                          <p class="searchtag"><?php echo get_abstract_text($post->ID); ?></p>
                          <a class="more" href='<?php the_permalink(); ?>'>More</a>
                   </div>
               </div>

           <?php endforeach; ?>
      </div>
      </div>

  </div>
  </div> <!-- main -->

<div class="col-md-4 uw-sidebar">
        <div id="secondary" class="right-bar" role="complementary">
          <div class="stripe-top"></div><div class="stripe-bottom"></div>
             <div id="sidebar">
              <?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
                        is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
             </div><!-- #sidebar -->
        </div><!-- #secondary -->
</div>

      </div><!-- .show-grid -->
    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>
