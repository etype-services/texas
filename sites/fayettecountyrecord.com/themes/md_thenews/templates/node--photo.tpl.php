<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
	<div class="node-inner">
  <?php 
	// TEASER
	if (!$page): 
		if ($node_display == 1):
	?>
  		<h2<?php print $title_attributes; ?> class="photo-title">
        <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
      </h2>
      <?php if ($display_submitted): ?>
        <div class="meta submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    
  	<?php if (isset($articleimage)): ?>
      <div class="photo-image">
        <a href="<?php print $node_url; ?>"><?php print $articleimage;?></a>
      </div>
    <?php endif; ?>
    <div class="photo-info">
    	<?php if ($node_display != 1): ?>
        <h2<?php print $title_attributes; ?> class="photo-title">
          <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
        </h2>
        <?php if ($display_submitted): ?>
          <div class="meta submitted">
            <?php print $user_picture; ?>
            <?php print $submitted; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
			<?php 
				hide($content['comments']);
        hide($content['links']);
        hide($content['field_photo']);
				print render($content);
			?>
    </div>
  <?php 
	// FULL NODE
	else: ?>
  

		<?php if ($display_submitted): ?>
      <div class="meta submitted">
        <?php print $user_picture; ?>
        <?php print $submitted; ?>
      </div>
    <?php endif; ?>
  	
    <?php 
			if (($node_share_position == 1) && ($facebook_display || $twitter_display || $gplus_display || $pinterest_display || $stumble_display)):
				require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/node.meta_share.inc';
			endif;
    ?>
    
    <div class="node-content clearfix"<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        hide($content['field_image']);
        print render($content);
      ?>
    </div>
  
    <?php
      // Remove the "Add new comment" link on the teaser page or if the comment
      // form is being displayed on the same page.
      if ($teaser || !empty($content['comments']['comment_form'])) {
        unset($content['links']['comment']['#links']['comment-add']);
      }
      // Only display the wrapper div if there are links.
      $links = render($content['links']);
      if ($links):
    ?>
      <div class="link-wrapper clearfix">
        <?php print $links; ?>
      </div>
    <?php endif; ?>
  
    <?php 
			if (($node_share_position == 2) && ($facebook_display || $twitter_display || $gplus_display || $pinterest_display || $stumble_display)):
				require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/node.meta_share.inc';
			endif;
    ?>
  
    <?php print render($content['comments']); ?>
  
	<?php endif; ?>
  </div>
</div>
