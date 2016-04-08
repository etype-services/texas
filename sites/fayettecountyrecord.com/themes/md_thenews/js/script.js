(function ($) {
	$(function(){
		
		equalheight();
		
		$('.meta_share div').each(function() {
			var html = $(this).html();
			html = html.replace(/<\!--/g, '');
			html = html.replace(/-->/g, '');
			jQuery(this).html(html);
		});
		
		$('.node-photo-teaser').wrapAll('<div class="photo-list clearfix" />');
		$('.node-video-teaser').wrapAll('<div class="video-list clearfix" />');
		
		$('.photo-3col .node-photo-teaser:nth-child(3n), .photo-4col .node-photo-teaser:nth-child(4n), .video-3col .node-video-teaser:nth-child(3n), .video-4col .node-video-teaser:nth-child(4n)').css({
			'margin-right':0
		});
		
		$('.photo-3col .node-photo-teaser:nth-child(3n+4), .photo-4col .node-photo-teaser:nth-child(4n+5), .video-3col .node-video-teaser:nth-child(3n+4), .video-4col .node-video-teaser:nth-child(4n+5)').css({
			'clear': 'both'
		});
    //
    $('.the-nav').cbFlyout();
		// Hover to change block title
		$('.block').mouseenter(function() {
				$(this).addClass('blockhover');
		}).mouseleave(function() {
				$(this).removeClass('blockhover');
		});

		// Editor's pick height
		editorpickHeight = $('#editorspick .views-row').maxHeight();
		$('#editorspick .view-content, #editorspick .views-row').css({'min-height':editorpickHeight});
		
		// Photo gallery
		photogalleryHeight = $('.view-photo-gallery .views-row').maxHeight();
		$('.view-photo-gallery .views-content, .view-photo-gallery .views-row').css({'min-height':photogalleryHeight});
		
		$(window).resize(function() {
			equalheight();
		});
		
		// Equal height slider & headline
		function equalheight() {
			$('#slider .blcontent, #headlines .blcontent').removeAttr('style');
			if ($(window).width() > 759) {
				sliderheight = $('#slider .blcontent').height();
				headlineheight = $('#headlines .blcontent').height() + $('#headlines .block-title').outerHeight() + 1;
				if (sliderheight > headlineheight) {
					headlineheight = sliderheight;
				}
				$('#slider .blcontent').height(headlineheight);
				$('#headlines .blcontent').height(headlineheight - $('#headlines .block-title').outerHeight() - 1);
			}
		}
		
  });
})(jQuery);


(function($) {
	$.fn.maxHeight = function() {
		tallest = 0;
		this.each(function() {
			if($(this).height() > tallest) {
				tallest = $(this).height();
			}
		});
		return tallest
	}
})(jQuery);