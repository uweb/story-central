
<?php get_header(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.0/isotope.pkgd.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/packery/1.4.1/packery.pkgd.js"></script>
<script>
  $( document ).ready( function() {

  // quick search regex
  var qsRegex;
  var buttonFilter;
  var filters = {};
  var counter = 0;

  var filterFunction = function() {
      var $this = $(this);
      var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
      var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
      if (searchResult && buttonResult){
        counter++;
      }
      return searchResult && buttonResult;
  }


  //init Isotope
  var $container = $('.isotope').isotope({
    itemSelector: '.element-item',
    masonry: {
      gutter: 10
    }
  });

  //run masonry on load
  $(window).load(function() {
    counter = 0; 
    $('.isotope').isotope({
      itemSelector: '.element-item',
      masonry: {
        gutter: 10
      }
    });
  });

  $('.filters-select').on( 'change', function() {
    $('#noresults').css({'visibility': 'hidden'});
    counter = 0; 
    var $this = $(this);
    var filterGroup = $this.attr('data-filter-group');
    filters[ filterGroup ] = this.value;
    buttonFilter = concatValues( filters );
    $container.isotope({ filter : filterFunction,
      masonry: {
        gutter: 10
      } 
    });
    if(counter==0){
      $('#noresults').css({'visibility': 'visible'});
    }
  });

  // use value of search field to filter
  $('#storycentral-search').on( 'keyup', function() {
    $('#noresults').css({'visibility': 'hidden'});
    counter = 0;
    var $this = $(this);
    var search = $('#storycentral-search').val();
    qsRegex = new RegExp( search, 'gi' );
    $container.isotope({ filter : filterFunction,
      masonry: {
        gutter: 10
      }
    });
    if(counter==0){
      $('#noresults').css({'visibility': 'visible'});
    }
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
<div id="flex-bg">
  <div class="img-src orig"></div>
  <div id="blurred-background" class="img-src blrd"></div>

  <div id="story-bank-info" class="container">
    <h1 class="uw-site-title"><?php the_title(); ?></h1>
    <span class="udub-slant"><span></span></span>
    <?php the_content(); ?>
  </div>
</div>
<?php endwhile; ?>



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

	<div class="col-md-6">
		<div class="form-horizontal">
		  <div class="form-group">
		      <label for="pillars" class="col-sm-2 control-label">Pillar:</label>
		      <div class="col-sm-10">
		        <select id="pillar" name="pillars" class="filters-select button-group form-control input-sm" data-filter-group="pillar">
		          <option value="*">Show all</option>
		          <?php foreach(get_pillars() as $pillar) : ?>
		            <option value=".<?php echo $pillar->slug; ?>"><?php echo $pillar->name ?></option>
		          <?php endforeach; ?>
		        </select>
		      </div>
		    </div>
		</div>
		
		<div class="form-horizontal">  
			<div class="form-group">
		      <label for="tags" class="col-sm-2 control-label"> Tag:</label>
		      <div class="col-sm-10">
		        <select id="tags" name="tags" class="filters-select button-group form-control input-sm" data-filter-group="tag">
		          <option value="*">Show all</option>
		          <?php foreach(get_tags() as $tag) : ?>
		            <option value=".<?php echo $tag->slug; ?>"><?php echo $tag->name ?></option>
		          <?php endforeach; ?>
		        </select>
		      </div>
		    </div>
		</div>
	 </div>

    <div class="search-field col-md-4 col-md-offset-1">

			<form role="search" method="get" id="searchform" class="searchform" action="http://128.208.132.220/cms/story-central/">
				<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="storycentral-search" id="storycentral-search"  placeholder="Search for:" autocomplete="off" class="searchbar quicksearch">
					<input id="searchsubmit" value="Search">
				</div>
			</form>

    </div>




</div>

</div>

      <div id="archive_section">
      <div id="noresults" style="visibility:hidden"><h3>No results found</h3></div>
      <div class="grid js-isotope isotope">
      <div class="grid-sizer"></div>
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

               <div class="boundless-tile grid-item element-item <?php echo $tags; ?>" >
                   <div class='boundless-image' style='background-image:url("<?php echo get_story_featured_image_url($post->ID, false, array(350,350)) ?>");' ></div>
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

      </div><!-- .show-grid -->
    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>
