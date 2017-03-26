<div id="page">
    <div class="page-inner <?php echo $grid_size ?>">

      <?php if ($page['user_menu']): ?>
          <nav id="user-menu" class="clearfix">
            <?php print render($page['user_menu']); ?>
            <?php print render($page['search_box']); ?>
              <div id="social">
                  <ul class="social-links">
                      <li><a class="facebook"
                             href="<?php echo $facebook ?>"></a></li>
                  </ul>
              </div>
          </nav>
      <?php endif; ?>

        <div class="header-wrapper clearfix">
            <div class="header-wrapper-inner <?php echo $grid_full_width ?>">
                <header>
                  <?php if ($logo): ?>
                      <div class="site-logo">
                      <a href="<?php print check_url($front_page); ?>"><img
                                  src="<?php print $logo ?>"
                                  alt="<?php print $site_name; ?>"/></a>
                      </div><?php print render($page['header']) ?>
                  <?php endif; ?>
                </header>
            </div>
        </div>
    </div>
</div>

<?php if ($page['main_menu']): ?>
    <div class="main-menu-wrapper clearfix">
        <div class="main-menu-wrapper-inner">
            <nav id="main-menu">
              <?php print render($page['main_menu']); ?>
            </nav>
        </div>
    </div>
<?php endif; ?>


<div id="page">
    <div class="page-inner <?php echo $grid_size ?>">

        <!-- Main Content -->
      <?php print render($tabs); ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?><h1 class="title" id="page-title">
          <span><?php print $title; ?></span></h1><?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print render($page['help']); ?>

        <div id="fullscreenlink"><span><a
                        href="http://www.mercolocal.com/<?php print $merco; ?>">Click
                here for full screen or mobile viewing.</a></span></div>

        <iframe src="http://www.mercolocal.com/<?php print $merco; ?>"
                width="100%" height="1500" scrolling="yes"
                align="center"></iframe>

      <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>


      <?php print render($page['content_bottom']); ?>

      <?php if ($page['postscript_1'] || $page['postscript_2'] || $page['postscript_3'] || $page['postscript_4']): ?>
          <div class="postscript-wrapper clearfix">
              <div class="postscript-wrapper-inner">
                  <div class="postscript-wrapper-inner-inner">
                      <section id="postscript">
                          <div class="grid_4"><?php print render($page['postscript_1']); ?></div>
                          <div class="grid_4"><?php print render($page['postscript_2']); ?></div>
                          <div class="grid_4"><?php print render($page['postscript_3']); ?></div>
                      </section>
                  </div>
              </div>
          </div>
      <?php endif; ?>
      <?php if ($page['footer']): ?>
        <?php print render($page['footer']); ?>
      <?php endif; ?>
    </div>
</div><!-- page -->
