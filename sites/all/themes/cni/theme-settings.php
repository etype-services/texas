<?php

drupal_add_css(drupal_get_path('theme', 'cni') . '/css/theme-settings.css', array(
  'group' => CSS_THEME,
  'weight' => 100
));

// Get the number of columns
function get_columns() {
  $grid_size = theme_get_setting('grid_size');
  $columns = array();
  for ($grid_unit = 0; $grid_unit <= $grid_size; $grid_unit++) {
    $columns[] = $grid_unit;
    $columns[$grid_unit] = $grid_unit . ' columns';
  }
  return $columns;
}

function cni_form_system_theme_settings_alter(&$form, $form_state) {

  $grid_size = theme_get_setting('grid_size');
  $col_number = get_columns();

  $form['advanced_settings'] = array(
    '#type' => 'vertical_tabs',
    '#title' => t('Advanced Theme Settings'),
    '#description' => t('Customize widths of the Preface and Postscript regions.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#weight' => -10,
    '#prefix' => t('<h3> Advanced Settings </h3>')
  );

  // Misc Settings (Facebook, Twitter, etc.)
  $form['advanced_settings']['misc_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Misc Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#weight' => -10,
  );

  $form['advanced_settings']['misc_settings']['twitter'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter'),
    '#size' => 10,
    '#default_value' => theme_get_setting('twitter'),
  );

  $form['advanced_settings']['misc_settings']['facebook'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook'),
    '#size' => 10,
    '#default_value' => theme_get_setting('facebook'),
  );

  $form['advanced_settings']['misc_settings']['pinterest'] = array(
    '#type' => 'textfield',
    '#title' => t('Pinterest'),
    '#size' => 10,
    '#default_value' => theme_get_setting('pinterest'),
  );

  $form['advanced_settings']['misc_settings']['instagram'] = array(
    '#type' => 'textfield',
    '#title' => t('Instagram'),
    '#size' => 10,
    '#default_value' => theme_get_setting('instagram'),
  );

  $form['advanced_settings']['misc_settings']['googleplus'] = array(
    '#type' => 'textfield',
    '#title' => t('Google Plus'),
    '#size' => 10,
    '#default_value' => theme_get_setting('googleplus'),
  );

  $form['advanced_settings']['misc_settings']['rssfeed'] = array(
    '#type' => 'textfield',
    '#title' => t('RSS Feed'),
    '#description' => t('Enter Yes to activate'),
    '#size' => 10,
    '#default_value' => theme_get_setting('rssfeed'),
  );

  $form['advanced_settings']['misc_settings']['e_edition'] = array(
    '#type' => 'textfield',
    '#title' => t('e-Edition'),
    '#description' => t('For one paper enter the e-Edition like <code>Mitchell%20News-JournalID617</code>, for more than one format like this: <code>Mitchell%20News-JournalID617|Mitchell News Journal,The%20Yorktown%20News-ViewID84|The Yorktown News View</code>'),
    '#size' => 10,
    '#default_value' => theme_get_setting('e_edition'),
  );

  $form['advanced_settings']['misc_settings']['pub'] = array(
    '#type' => 'textfield',
    '#title' => t('Pub'),
    '#description' => t('Separate multiple entries with a comma, in the same order as the e-Editions'),
    '#size' => 10,
    '#default_value' => theme_get_setting('pub'),
  );

  $form['advanced_settings']['misc_settings']['ptype'] = array(
    '#type' => 'textfield',
    '#title' => t('PType'),
    '#description' => t('Separate multiple entries with a comma, in the same order as the e-Editions'),
    '#size' => 10,
    '#default_value' => theme_get_setting('ptype'),
  );

  $form['advanced_settings']['misc_settings']['nav_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Navigation Background Color'),
    '#description' => t('Optional, include initial #'),
    '#size' => 10,
    '#default_value' => theme_get_setting('nav_color'),
  );

  $form['advanced_settings']['misc_settings']['max_nav_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Max Main Navigation Width'),
    '#description' => t('Optionally constrain main navigation width'),
    '#size' => 10,
    '#default_value' => theme_get_setting('max_nav_width'),
  );

  $form['advanced_settings']['misc_settings']['logo_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Logo Width'),
    '#description' => t('Optional maximum allowed width for logo'),
    '#size' => 10,
    '#default_value' => theme_get_setting('logo_width'),
  );

  // Grid Settings
  $form['advanced_settings']['grid_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Grid Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE
  );

  $form['advanced_settings']['grid_settings']['grid_size'] = array(
    '#type' => 'select',
    '#title' => t('Grid Size'),
    '#default_value' => theme_get_setting('grid_size'),
    '#options' => array(
      12 => t('12 columns')
    ),
  );

  $form['advanced_settings']['grid_settings']['sidebar_grid_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Sidebar Grid Settings'),
    '#description' => t('Customize the Sidebars.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#attributes' => array(
      'class' => array('form-inline'),
    ),
    '#prefix' => t('<h3> Sidebar Grid Settings </h3>')
  );

  $form['advanced_settings']['grid_settings']['sidebar_grid_settings']['sidebar_layout'] = array(
    '#type' => 'select',
    '#title' => t('Sidebar Layout'),
    '#default_value' => theme_get_setting('sidebar_layout'),
    '#options' => array(
      'sidebars-both-first' => t('Both Sidebars First'),
      'sidebars-both-second' => t('Both Sidebars Second'),
      'sidebars-split' => t('Split Sidebars'),
    ),
  );

  $form['advanced_settings']['grid_settings']['sidebar_grid_settings']['sidebar_first_width'] = array(
    '#type' => 'select',
    '#title' => t('Sidebar First'),
    '#default_value' => theme_get_setting('sidebar_first_width'),
    '#options' => $col_number,
  );

  $form['advanced_settings']['grid_settings']['sidebar_grid_settings']['sidebar_second_width'] = array(
    '#type' => 'select',
    '#title' => t('Sidebar Second'),
    '#default_value' => theme_get_setting('sidebar_second_width'),
    '#options' => $col_number,
  );

  $form['advanced_settings']['grid_settings']['preface_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('More Grid Settings'),
    '#description' => t('Customize widths of the Preface regions.  Note that all four values combined should ideally add up to ' . $grid_size . '.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#attributes' => array(
      'class' => array('form-inline'),
    ),
    '#prefix' => t('<h3> Preface Grid Widths </h3>')
  );

  $form['advanced_settings']['grid_settings']['postscript_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('More Grid Settings'),
    '#description' => t('Customize widths of the Postscript regions.  Note that all four values combined should ideally add up to ' . $grid_size . '.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#attributes' => array(
      'class' => array('form-inline'),
    ),
    '#prefix' => t('<h3> Postscript Grid Widths </h3>')
  );

  for ($region_count = 1; $region_count <= 4; $region_count++) {

    $form['advanced_settings']['grid_settings']['preface_settings']['preface_' . $region_count . '_grid_width'] = array(
      '#type' => 'select',
      '#title' => t('Preface ' . $region_count),
      '#default_value' => theme_get_setting('preface_' . $region_count . '_grid_width'),
      '#options' => $col_number,
    );

    $form['advanced_settings']['grid_settings']['postscript_settings']['postscript_' . $region_count . '_grid_width'] = array(
      '#type' => 'select',
      '#title' => t('Postscript ' . $region_count),
      '#default_value' => theme_get_setting('postscript_' . $region_count . '_grid_width'),
      '#options' => $col_number,
    );

  }

}
