$(document).ready(function() {

  $(window).scroll(function(e) {
      $('#blurred-background').css( 'opacity', $(this).scrollTop() / 150 )
  });

});
