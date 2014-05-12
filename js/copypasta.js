$(document).ready(function() {

  if ( swfobject && swfobject.getFlashPlayerVersion().major === 0 )
  {
      return;
  }


  $('.copy').each(function() {
    var $this = $(this)
    if ( $this.attr('class').indexOf('gallery') > -1 ) return
    $this.after('<a class="copy-link button">Copy</a>')
  });


  $('.copy-link').zclip( {

    path: '/wp-content/themes/story/js/libs/ZeroClipboard.swf',

    copy : function() {
      return $(this).siblings('.copy').html()
    },

    afterCopy:function(){
      var alert = $(this).closest('.widget').append('<div class="alert alert-success">Copied to clipboard</div>').find('.alert')

      _.delay( function() {
        alert.fadeOut()
      }, 1000)

    }

  }).mouseenter( function() {

    $(this).closest('.widget').css({outline: '2px dashed #eee'} )

  }).mouseleave( function() {

    $(this).closest('.widget').css({outline: ''} )

  })


});
