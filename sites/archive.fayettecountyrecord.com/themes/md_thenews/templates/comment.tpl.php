<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <div class="attribution">
    <?php print $picture; ?>
  </div>

  <div class="comment-text"><div class="comment-inner">	
    <div class="submitted">
        <div><?php print $author; ?></div>
        <div>
            <?php print $created; ?>
            <?php if ($new): ?>
		      <span class="new"><?php print $new; ?></span>
		    <?php endif; ?>
        </div>
    </div>

    <div class="content"<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['links']);
        print render($content);
      ?>
      <?php if ($signature): ?>
      <div class="user-signature clearfix">
        <?php print $signature; ?>
      </div>
      <?php endif; ?>
    </div> <!-- /.content -->

    <?php print render($content['links']); ?>
  </div></div> <!-- /.comment-text -->
  
</div>
