<div id="page-top">
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

                    <!-- Main 1 -->
                    <div class="main clearfix">
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

                          <?php if ($page['preface_1']): ?>
                              <div class="preface-wrapper
                                preface-wrapper-top clearfix">
                                  <div class="preface-wrapper-inner">
                                      <div class="preface-wrapper-inner-inner">
                                          <section id="preface_1">
                                              <div><?php print render
                                                ($page['preface_1']); ?></div>
                                          </section>
                                      </div>
                                  </div>
                              </div>
                          <?php endif; ?>

                        </div>
                      <?php if ($page['sidebar_first']): ?>
                          <aside class="sidebar first-sidebar grid_4 clearfix">
                            <?php print render($page['sidebar_first']); ?>
                          </aside>
                      <?php endif; ?>
                    </div>

                    <!-- Main 2 Editor's Pick-->
                    <div class="main clearfix">
                        <div class="main-inner grid_12">
                          <?php print render($page['content_middle']); ?>
                        </div>


                        <!-- Main 3 -->
                        <div class="main clearfix">
                            <div class="main-inner grid_8">

                              <?php if ($page['preface_2'] || $page['preface_3']): ?>
                                  <div class="preface-wrapper clearfix">
                                      <div class="preface-wrapper-inner">
                                          <div class="preface-wrapper-inner-inner">
                                              <section id="preface">
                                                  <div><?php print render($page['preface_2']); ?></div>
                                                  <div><?php print render($page['preface_3']); ?></div>
                                              </section>
                                          </div>
                                      </div>
                                  </div>
                              <?php endif; ?>


                            </div>

                          <?php if ($page['sidebar_second']): ?>
                              <aside class="sidebar second-sidebar grid_4 clearfix">
                                <?php print render($page['sidebar_second']); ?>
                              </aside>
                          <?php endif; ?>
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
                          <div class="grid_4"><?php print render($page['postscript_1']); ?></div>
                          <div class="grid_4"><?php print render($page['postscript_2']); ?></div>
                          <div class="grid_4"><?php print render($page['postscript_3']); ?></div>
                      </section>
                    <?php if ($page['postscript_banner']): ?>
                        <section id="postscript_banner">
                            <div class="grid_12"><?php print render($page['postscript_banner']); ?></div>
                        </section>
                    <?php endif; ?>
                  </div>
              </div>
          </div>
      <?php endif; ?>
      <?php if ($page['footer']): ?>
        <?php print render($page['footer']); ?>
      <?php endif; ?>

    </div>
</div><!-- page -->
