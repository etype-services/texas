<div id="page">
  <div class="page-inner <?php echo $grid_size ?>">

    <?php if ($page['user_menu']): ?>
      <nav id="user-menu" class="clearfix">
        <?php print render($page['user_menu']); ?>
        <?php print render($page['search_box']); ?>
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

<?php if ($page['main_menu_second_level']): ?>
  <div class="main-menu-second-level-wrapper clearfix">
    <div class="main-menu-second-level-wrapper-inner">
      <nav id="main-menu-second-level">
        <?php print render($page['main_menu_second_level']); ?>
      </nav>
    </div>
  </div>
<?php endif; ?>

<div id="page">
  <div class="page-inner <?php echo $grid_size ?>">

    <!-- Main Content -->
    <div class="main-content-wrapper clearfix">
      <div class="main-content-wrapper-inner">
        <section id="main-content">

          <div class="main">
            <div class="main-inner grid_8">

              <?php if ($page['slideshow']): ?>
                <div class="slideshow-wrapper clearfix">
                  <div class="slideshow-wrapper-inner">
                    <div id="slideshow">
                      <?php print render($page['slideshow']); ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($page['highlighted']): ?>
                <div
                  id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
              <?php print render($tabs); ?>
              <?php if (!isset($node)): ?>
                <?php print render($title_prefix); ?>
                <?php if ($title): ?><h1 class="title" id="page-title">
                  <span><?php print $title; ?></span></h1><?php endif; ?>
                <?php print render($title_suffix); ?>
              <?php endif; ?>
              <?php print render($page['help']); ?>
              <?php print render($page['content']); ?>
              <?php if ($action_links): ?>
                <ul
                  class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
            </div>

            <aside class="sidebar second-sidebar grid_4 clearfix">
              <?php print render($page['sidebar_first']); ?>
              <?php print render($page['sidebar_second']); ?>
            </aside>
          </div>

        </section>
      </div>
    </div>

    <?php print render($page['content_bottom']); ?>

    <?php if ($page['postscript_1'] || $page['postscript_2'] || $page['postscript_3'] || $page['postscript_4']): ?>
      <div class="postscript-wrapper clearfix">
        <div class="postscript-wrapper-inner">
          <div class="postscript-wrapper-inner-inner">
            <section id="postscript">
              <div
                class="grid_3"><?php print render($page['postscript_1']); ?></div>
              <div
                class="grid_3"><?php print render($page['postscript_2']); ?></div>
              <div
                class="grid_3"><?php print render($page['postscript_3']); ?></div>
              <div
                class="grid_3"><?php print render($page['postscript_4']); ?></div>
            </section>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div><!-- page -->