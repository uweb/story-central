$(document).ready(function() {

  var $window = $(window)
    , $blur   = $('#blurred-background')

  $window.scroll(function(e) {
    var top = $window.scrollTop()

    $blur.css( 'opacity', top / 150 > 1 ? 1 : top / 150 );

  });

});
