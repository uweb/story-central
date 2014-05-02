$(document).ready(function() {

$('.entry-content .widget').each(function() {
  $(this).append('<a class="copy pull-right button">Copy</a>')
});

$('.copy').zclip( {
  path: '/wp-content/themes/story/js/libs/ZeroClipboard.swf',
  copy : function() {
    return $(this).siblings('.textwidget').html()
  },
  afterCopy:function(){
    var alert = $(this).closest('.widget').append('<div class="alert alert-success">Copied to clipboard</div>').find('.alert')

    _.delay( function() {
      alert.fadeOut()
    }, 500)

  }
}).mouseenter( function() {
  $(this).closest('.widget').css({outline: '2px dashed #eee'} )
}).mouseleave( function() {
  $(this).closest('.widget').css({outline: ''} )
})

});
