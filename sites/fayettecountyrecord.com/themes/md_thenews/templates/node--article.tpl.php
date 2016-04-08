<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php 
	// TEASER
	if (!$page): 
		if (($node_display != 5) && ($node_display != 6)):
	?>
      <h2<?php print $title_attributes; ?> class="article-title">
        <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
      </h2>
      
      <?php if ($display_submitted): ?>
        <div class="meta submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <div class="article-wrap clearfix">
			<?php if (isset($articleimage)): ?>
        <div class="article-image">
          <a href="<?php print $node_url; ?>"><?php print $articleimage;?></a>
        </div>
      <?php endif; ?>
      <div class="article-info">
      	<?php if (($node_display == 5) || ($node_display == 6)):?>
          <h2<?php print $title_attributes; ?> class="article-title">
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
          // We hide the comments and links now so that we can render them later.
          hide($content['comments']);
          hide($content['links']);
          hide($content['field_image']);
          print render($content);
  
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
      </div> <!-- /. article-info -->
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
        //hide($content['field_image']);
        print render($content);
      ?>
    </div>
    
    <?php 
			if (($node_share_position == 2) && ($facebook_display || $twitter_display || $gplus_display || $pinterest_display || $stumble_display)):
				require_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'md_thenews') . '/inc/node.meta_share.inc';
			endif;
    ?>
  
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

    <?php print render($content['comments']); ?>
  
	<?php endif; ?>
</div>
