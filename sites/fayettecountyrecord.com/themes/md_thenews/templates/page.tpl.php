<div id="left-flyout-nav" class="layout-left-flyout visible-sm"></div>
<div class="layout-right-content">
<?php if ($page['pushmenu']): ?>
  <?php print render($page['pushmenu']); ?>
<?php endif; ?>
<?php include 'page.header.inc'; ?>
<div id="main-content" class="<?php print $mainclass;?>"><div class="wrap clearfix">
  	<?php if ($messages): ?>
      <div id="messages">
        <?php print $messages; ?>
      </div> <!-- /#messages -->
    <?php endif; ?>
    
    <?php if ($contentop_blocks): $x=0; ?>
      <div id="contentop-blocks" class="clearfix">
        <?php foreach($contenttop_columns[$contentop_blocks] as $col):
          $x++;
          if($x == 1){ $class = " first"; } else {$class = "";}
        ?>
          <div class="<?php echo $col.$class; ?>">
             <?php print render($page['contentt_'.$x]); ?>
          </div>
        <?php endforeach; ?>
      </div><!-- /#contentop-blocks -->
    <?php endif; ?>
      
    <div id="content" class="<?php print $columclass;?>"><div class="content-inner">
	    
	    <?php if ($breadcrumb): ?>
        <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php endif; ?>
      <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="title" id="page-title">
          <?php print $title; ?>
        </h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php if ($tabs): ?>
        <div class="tabs">
          <?php print render($tabs); ?>
        </div>
      <?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links">
          <?php print render($action_links); ?>
        </ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php if ($page['content_bottom']): ?><div id="content-bottom"><?php print render($page['content_bottom']); ?></div><?php endif; ?>
    </div></div><!-- /#content -->
    <?php if ($page['sidebar'] || $page['sidebar_col1'] || $page['sidebar_col2'] || $page['sidebar_bottom']): ?>
      <div id="sidebar" class="column sidebar">
        <?php if ($page['sidebar']): print render($page['sidebar']); endif; ?>
        <div class="clearfix">
        	<?php if ($page['sidebar_col1']): ?>
            <div id="sidebar-col1">
              <?php print render($page['sidebar_col1']); ?>
            </div> <!-- /#sidebar-col1 -->
          <?php endif; ?>
          <?php if ($page['sidebar_col2']): ?>
            <div id="sidebar-col2">
              <?php print render($page['sidebar_col2']); ?>
            </div> <!-- /#sidebar-col2 -->
          <?php endif; ?>
        </div>
        <?php if ($page['sidebar_bottom']): print render($page['sidebar_bottom']); endif; ?>
      </div> <!-- /#sidebar -->
    <?php endif; ?>
</div>
<?php include 'page.footer.inc'; ?>
</div>
</div>