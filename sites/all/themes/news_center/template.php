<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can modify or override Drupal's theme
 *   functions, intercept or make additional variables available to your theme,
 *   and create custom PHP logic. For more information, please visit the Theme
 *   Developer's Guide on Drupal.org: http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to STARTERKIT_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: STARTERKIT_breadcrumb()
 *
 *   where STARTERKIT is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override either of the two theme functions used in Zen
 *   core, you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */

/**
 * @param $head_elements
 */
function news_center_html_head_alter(&$head_elements) {

    global $base_url;
    $base_path = base_path();
    $conf_path = conf_path();

    /* remove current favicon if updated favicons exit */
    $icon_path = $base_path . $conf_path .'/files/favicons';

    if (is_dir($_SERVER['DOCUMENT_ROOT'] . $icon_path)) {

        $orig_icon_path = $base_path . $conf_path .'/files';
        $favicon = 'drupal_add_html_head_link:shortcut icon:' . $base_url . $orig_icon_path . '/favicon.ico';
        unset($head_elements[$favicon]);

    }
}

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */

function news_center_preprocess_html(&$variables, $hook) {

    /* add site-specific css */
    $base_path = base_path();
    $conf_path = conf_path();
    $site_css = $base_path . $conf_path . '/local.css';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $site_css)) {
        drupal_add_css(
            $site_css,
            array(
                'type' => 'file',
                'media' => 'all',
                'preprocess' => FALSE,
                'every_page' => TRUE,
                'weight' => 999,
                'group' => CSS_THEME
            )
        );
    }

    /* add site setting css */
    $nav_color = theme_get_setting('nav_color');
    if (!empty($nav_color)) {
        drupal_add_css(
            '#block-superfish-1 {background: '. $nav_color .' !important;}',
            array(
                'group' => CSS_THEME,
                'type' => 'inline',
                'media' => 'screen',
                'preprocess' => FALSE,
                'weight' => '9999',
            )
        );
    }

    $body_background = theme_get_setting('body_background');
    if (!empty($body_background)) {
        drupal_add_css(
            'body {background: '. $body_background .' !important;}',
            array(
                'group' => CSS_THEME,
                'type' => 'inline',
                'media' => 'screen',
                'preprocess' => FALSE,
                'weight' => '9999',
            )
        );
    }


    /* add favicons if they exist */
    $icon_path = $base_path . $conf_path .'/files/favicons';
    if (is_dir($_SERVER['DOCUMENT_ROOT'] . $icon_path)) {

        $icon_path .= '/';

        $theme_color = array(
            '#type' => 'html_tag',
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'theme-color',
                'content' => '#ffffff',
            )
        );
        drupal_add_html_head($theme_color, 'theme_color');

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_path . 'safari-pinned-tab.svg')) {
            $mask_icon = array(
                '#type' => 'html_tag',
                '#tag' => 'link',
                '#attributes' => array(
                    'rel' => 'mask-icon',
                    'href' => $icon_path . 'safari-pinned-tab.svg',
                    'color' => '#5bbad5',
                )
            );
            drupal_add_html_head($mask_icon, 'mask_icon');

        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_path . 'manifest.json')) {
            $manifest = array(
                '#type' => 'html_tag',
                '#tag' => 'link',
                '#attributes' => array(
                    'rel' => 'manifest',
                    'href' => $icon_path . 'manifest.json',
                )
            );
            drupal_add_html_head($manifest, 'manifest');
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_path . 'favicon-16x16.png')) {
            $icon16 = array(
                '#type' => 'html_tag',
                '#tag' => 'link',
                '#attributes' => array(
                    'rel' => 'icon',
                    'type' => 'image/png',
                    'sizes' => '16x16',
                    'href' => $icon_path . 'favicon-16x16.png',
                )
            );
            drupal_add_html_head($icon16, 'icon16');
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_path . 'favicon-32x32.png')) {
            $icon32 = array(
                '#type' => 'html_tag',
                '#tag' => 'link',
                '#attributes' => array(
                    'rel' => 'icon',
                    'type' => 'image/png',
                    'sizes' => '32x32',
                    'href' => $icon_path . 'favicon-32x32.png',
                )
            );
            drupal_add_html_head($icon32, 'icon32');
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $icon_path . 'apple-touch-icon.png')) {
            $appletouchicon = array(
                '#type' => 'html_tag',
                '#tag' => 'link',
                '#attributes' => array(
                    'rel' => 'apple-touch-icon',
                    'sizes' => '180x180',
                    'href' => $icon_path . 'apple-touch-icon.png',
                )
            );
            drupal_add_html_head($appletouchicon, 'apple-touch-icon');
        }

    }



  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // STARTERKIT_preprocess_node_page() or STARTERKIT_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  $variables['classes_array'][] = 'count-' . $variables['block_id'];
}
// */
