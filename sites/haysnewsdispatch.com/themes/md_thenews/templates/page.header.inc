<div id="header" class="clearfix">
  <div class="wrap clearfix">
    <?php if ($logo): ?>
      <div id="logo">
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
        <?php if ($site_slogan): ?>
          <span class="slogan<?php if ($hide_site_slogan) { print ' element-invisible'; } ?>">
            <?php print $site_slogan; ?>
          </span>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($site_name): ?>
      <div id="name-and-slogan"<?php if ($hide_site_name && $hide_site_slogan) { print ' class="element-invisible"'; } ?>>

        <?php if ($site_name): ?>
          <?php if ($title): ?>
            <div id="site-name"<?php if ($hide_site_name) { print ' class="element-invisible"'; } ?>>
              <strong>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </strong>
            </div>
          <?php else: /* Use h1 when the content title is empty */ ?>
            <h1 id="site-name"<?php if ($hide_site_name) { print ' class="element-invisible"'; } ?>>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </h1>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($site_slogan): ?>
          <div id="site-slogan"<?php if ($hide_site_slogan) { print ' class="element-invisible"'; } ?>>
            <?php print $site_slogan; ?>
          </div>
        <?php endif; ?>

      </div> <!-- /#name-and-slogan -->
    <?php endif; ?>

    <?php if (!empty($page['header_ads'])): ?>
        <div class="header-ads">
          <?php print render($page['header_ads']);?>
        </div>
    <?php endif; ?>
  </div>



  <?php if ($main_menu || $page['superfish']): ?>
    <div id="nav">
      <div class="wrap">
      
		<?php if (!empty($page['superfish'])): print render($page['superfish']); endif; ?>
        <?php if (empty($page['superfish'])) { 
          print theme('links__system_main_menu', array(
            'links' => $main_menu,
            'attributes' => array(
              'id' => 'main-menu-links',
              'class' => array('links', 'clearfix'),
            ),
            'heading' => array(
              'text' => t('Main menu'),
              'level' => 'h2',
              'class' => array('element-invisible'),
            ),
          ));
				} ?>
        <div class="navbar container">
        <!-- Trigger -->
		      <a class="btn-navbar btn-navbar-navtoggle btn-flyout-trigger" href="#">
		        <span class="icon-bar btn-flyout-trigger"></span>
		        <span class="icon-bar btn-flyout-trigger"></span>
		        <span class="icon-bar btn-flyout-trigger"></span>
		      </a>
          <nav class="the-nav nav-collapse clearfix">
        <?php if (!empty($primary_nav)): ?>
          <?php print render($primary_nav); ?>
        <?php endif; ?>
          </nav>
        </div>
      </div><!-- /.wrap -->
      <?php if (!empty($page['superfish'])): ?><div class="subnav"></div><?php endif; ?>
    </div><!-- /#nav -->
  <?php endif; ?>
   <?php if ($page['leaderboard']): print render($page['leaderboard']); endif; ?>
</div><!-- /#header -->