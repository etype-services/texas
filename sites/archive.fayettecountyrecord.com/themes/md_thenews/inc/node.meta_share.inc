<div class="meta-share-wrap"><div class="meta_share clearfix">
	<?php if ($facebook_display): 
		if ( $facebook_layout == 'box_count') {
			$facebook_height = 70;
		} else {
			$facebook_height = 25;
		}
	?>
  <div class="facebook">
<!--
		<iframe src="http://www.facebook.com/plugins/like.php?href=<?php print urlencode($nodeurl);?>&amp;send=false&amp;layout=<?php print $facebook_layout; ?>&amp;show_faces=false&amp;width=90&amp;action=like&amp;font=<?php print $facebook_display_font; ?>&amp;colorscheme=<?php print $facebook_display_color; ?>&amp;height=<?php print $facebook_height;?>" scrolling="no" frameborder="0" style="border: 0; overflow:hidden; height: <?php print $facebook_height;?>px; width:50px;" allowTransparency="true"></iframe>
-->
	</div>
  <?php endif; ?>
  
  <?php if ($twitter_display): ?>
  <div class="twitter">
<!--
		<a href="http://twitter.com/share?" class="twitter-share-button" data-url="<?php print $nodeurl;?>" data-text="<?php print $title; ?>" data-count="<?php print $twitter_display_style; ?>" data-lang="<?php print $twitter_display_lang; ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
-->
	</div>
  <?php endif; ?>
  
  <?php if ($pinterest_display): ?>
  <div class="pinterest">
<!--	
  <a href="http://pinterest.com/pin/create/button/?url=<?php print urlencode($nodeurl);?>&media=<?php print urlencode($pinterest_media);?>&description=<?php print $title; ?>" class="pin-it-button" count-layout="<?php print $pinterest_layout; ?>"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
-->
	</div>
  <?php endif; ?>
  
  <?php if ($gplus_display): ?>
  <div class="googleplus">
<!--	
	<g:plusone size="<?php print $gplus_display_size; ?>" annotation="<?php print $gplus_annotation; ?>" href="<?php print $nodeurl;?>"<?php if ($gplus_annotation == 'inline'): ?> width="180"<?php endif;?>></g:plusone>
-->
	</div>
  <?php endif; ?>
  
	<?php if ($stumble_display): ?>
  <div class="stumbleupon">
		<script src="http://www.stumbleupon.com/hostedbadge.php?s=<?php print $stumble_display_style; ?>&amp;r=<?php print $nodeurl;?>"></script>
	</div>
  <?php endif; ?>
</div></div>