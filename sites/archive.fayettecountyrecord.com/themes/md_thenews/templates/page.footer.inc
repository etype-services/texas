<?php if ($bottom_blocks): $x=0; ?>
  <div id="bottom"><div class="wrap clearfix">
    <?php foreach($bottom_columns[$bottom_blocks] as $col):
      $x++;
      if($x == 1){ $class = " first"; } elseif ($x == count($bottom_columns[$bottom_blocks])) { $class = " last";} else {$class = "";}
    ?>
      <div class="<?php echo $col.$class; ?>">
         <?php print render($page['bottom_'.$x]); ?>
      </div>
    <?php endforeach; ?>
  </div></div><!-- /.wrap /#bottom -->
<?php endif; ?>


<div id="footer"><div class="wrap clearfix">
  <?php if ($page['footer']): ?>
    <div class="ft-block">
      <?php print render($page['footer']); ?>
    </div>
  <?php endif; ?>

</div> <!-- /#footer -->