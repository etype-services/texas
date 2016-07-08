jQuery(document).ready(function($) {
  var project_path = $('#project_path').text();
  if (swfobject.getFlashPlayerVersion().major <= 9) {
    var _slideshow = SOUNDSLIDES.player;

    _slideshow.config = {
      'container_div': 'object',
      'path': '/' + project_path + '/',
      'path_to_jplayer_swf' : '_files/',
      'width': 800,
      'height': 596
    };

    _slideshow.init();
  }
});
