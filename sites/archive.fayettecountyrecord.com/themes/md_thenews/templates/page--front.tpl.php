<div id="left-flyout-nav" class="layout-left-flyout visible-sm"></div>
<div class="layout-right-content">
<?php include 'page.header.inc'; ?>

<?php if ($page['slider'] || $page['headlines']): ?>
	<div id="spotlight" class="<?php print $withheadlines;?>"><div class="wrap clearfix">
		<?php if ($page['slider']): ?>
			<div id="slider">
				<?php print render($page['slider']); ?>
			</div> <!-- /#slider -->
		<?php endif; ?>
		
		<?php if ($page['headlines']): ?>
			<div id="headlines">
				<?php print render($page['headlines']); ?>
			</div> <!-- /#headlines -->
		<?php endif; ?>
	</div></div><!-- /#spotlight -->
<?php endif; ?>

<?php if ($page['editorspick']): ?>
	<div id="editorspick"><div class="wrap clearfix">
		<?php print render($page['editorspick']); ?>
	</div></div> <!-- #editorspick -->
<?php endif; ?>
  
<div id="main-content" class="<?php print $mainclass;?>"><div class="wrap clearfix">
	<div id="content-left">
  	<?php if ($messages): ?>
      <div id="messages"><?php print $messages; ?></div> <!-- /#messages -->
    <?php endif; ?>
		<?php if ($page['content_top']): ?><div id="content-top"><?php print render($page['content_top']); ?></div><?php endif; ?>
    <?php if ($front_page_content): ?>
      <?php if ($breadcrumb): ?>
        <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php endif; ?>
      <div id="content">
        <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
        <?php print render($title_prefix); ?>
        <?php if ($title): ?>
          <h1 class="title" id="page-title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php if ($tabs): ?>
          <div class="tabs"><?php print render($tabs); ?></div>
        <?php endif; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
      </div><!-- /#content -->
    <?php endif; ?>
    <?php if ($page['content_bottom']): ?><div id="content-bottom"><?php print render($page['content_bottom']); ?></div><?php endif; ?>
  </div><!-- /#content-left -->
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
  
</div></div><!-- /#main-content -->
<?php include 'page.footer.inc'; ?>
</div>